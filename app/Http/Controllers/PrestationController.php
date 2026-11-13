<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestationController extends Controller
{
    // Afficher la liste des prestations
  public function index(Request $request)
    {
        $recherche = $request->query('search');

        $prestations = Prestation::query()
            ->when($recherche, function ($query) use ($recherche) {
                $query->where(function ($q) use ($recherche) {
                    $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('categorie', 'like', "%{$recherche}%")
                    ->orWhere('description', 'like', "%{$recherche}%");
                });
            })
            ->latest()
            ->paginate(4)
            ->withQueryString();

        $total     = Prestation::count();
        $actives   = Prestation::where('statut', true)->count();
        $inactives = $total - $actives;
        $prixMoyen = Prestation::avg('prix') ?? 0;

        return view('prestations.index', compact(
            'prestations', 'total', 'actives', 'inactives', 'prixMoyen'
        ));
    }

    // Afficher le formulaire d'ajout
    public function create()
    {
        return view('prestations.create');
    }

    // Enregistrer une prestation
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie'   => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $donnees = $request->except('image');

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')
                ->store('prestations', 'public');
        }

        $donnees['statut'] = $request->boolean('statut');

        Prestation::create($donnees);

        return redirect()->route('prestations.index')
            ->with('success', 'Prestation ajoutée avec succès !');
    }

    // Afficher le formulaire de modification
    public function edit(Prestation $prestation)
    {
        return view('prestations.edit', compact('prestation'));
    }

    // Mettre à jour une prestation
    public function update(Request $request, Prestation $prestation)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie'   => 'required|string|max:255',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $donnees = $request->except('image');

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($prestation->image) {
                Storage::disk('public')->delete($prestation->image);
            }

            $donnees['image'] = $request->file('image')
                ->store('prestations', 'public');
        }

        $donnees['statut'] = $request->boolean('statut');

        $prestation->update($donnees);

        return redirect()->route('prestations.index')
            ->with('success', 'Prestation modifiée avec succès !');
    }

    // Supprimer une prestation
    public function destroy(Prestation $prestation)
    {
        if ($prestation->image) {
            Storage::disk('public')->delete($prestation->image);
        }

        $prestation->delete();

        return redirect()->route('prestations.index')
            ->with('success', 'Prestation supprimée avec succès !');
    }
}