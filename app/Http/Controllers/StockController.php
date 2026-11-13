<?php

namespace App\Http\Controllers;

use App\Enums\TypeMouvementStock;
use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $recherche = $request->string('q')->toString();
        $alerteSeulement = $request->boolean('alerte');

        $produits = Produit::query()
            ->when($recherche, function ($q) use ($recherche) {
                $q->where(function ($q) use ($recherche) {
                    $q->where('nom', 'like', "%{$recherche}%")
                        ->orWhere('categorie', 'like', "%{$recherche}%")
                        ->orWhere('fournisseur', 'like', "%{$recherche}%");
                });
            })
            ->when($alerteSeulement, fn ($q) => $q->whereColumn('quantite', '<=', 'seuil_alerte'))
            ->orderBy('nom')
            ->paginate(20)
            ->withQueryString();

        return view('stock.index', [
            'produits'        => $produits,
            'types'           => TypeMouvementStock::cases(),
            'recherche'       => $recherche,
            'alerteSeulement' => $alerteSeulement,
            'nbAlertes'       => Produit::whereColumn('quantite', '<=', 'seuil_alerte')->count(),
        ]);
    }

    /**
 * Affiche l'historique des mouvements d'un produit.
 */
public function mouvement(Produit $stock): View
{
    $mouvements = MouvementStock::with('auteur')
        ->where('produit_id', $stock->id)
        ->orderByDesc('created_at')
        ->paginate(20);

    return view('stock.mouvement', [
        'produit' => $stock,
        'mouvements' => $mouvements,
    ]);
}

    /**
     * Enregistre un mouvement et met à jour la quantité du produit.
     * La quantité saisie est signée : positive pour une entrée, négative pour une sortie.
     */
    public function ajuster(Request $request, Produit $produit): RedirectResponse
    {
        $data = $request->validate([
            'type'     => ['required', Rule::enum(TypeMouvementStock::class)],
            'quantite' => ['required', 'numeric', 'not_in:0', 'between:-99999999,99999999'],
            'motif'    => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($produit, $data, $request) {
                // Verrou pour éviter deux mises à jour simultanées sur le même produit
                $produit = Produit::whereKey($produit->id)->lockForUpdate()->firstOrFail();

                $nouveauStock = round((float) $produit->quantite + (float) $data['quantite'], 2);

                if ($nouveauStock < 0) {
                    throw new \DomainException(
                        "Stock insuffisant : il reste {$produit->quantite} {$produit->unite} de « {$produit->nom} »."
                    );
                }

                $produit->quantite = $nouveauStock;
                $produit->save();

                MouvementStock::create([
                    'produit_id'     => $produit->id,
                    'type'           => $data['type'],
                    'quantite'       => $data['quantite'],
                    'stock_apres'    => $nouveauStock,
                    'motif'          => $data['motif'],
                    'enregistre_par' => $request->user()->id,
                ]);
            });
        } catch (\DomainException $e) {
            return back()->withErrors(['quantite' => $e->getMessage()])->withInput();
        }

        return back()->with('success', 'Mouvement enregistré, stock mis à jour.');
    }
}