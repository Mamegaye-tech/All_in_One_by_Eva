<?php

namespace App\Http\Controllers;

use App\Models\CategorieDepense;
use App\Models\Depense;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepenseController extends Controller
{
    public function index(Request $request): View
    {
        $mois = $request->input('mois', now()->format('Y-m'));
        $debut = Carbon::createFromFormat('Y-m', $mois)->startOfMonth();
        $fin = $debut->copy()->endOfMonth();

        $requete = Depense::with(['categorie', 'auteur'])
            ->whereBetween('date_depense', [$debut, $fin])
            ->when($request->filled('categorie'), fn ($q) => $q->where('categorie_depense_id', $request->categorie));

        $totalMois = (clone $requete)->sum('montant');

        $depenses = $requete->latest('date_depense')->latest('id')->paginate(10)->withQueryString();
        $categories = CategorieDepense::orderBy('nom')->get();

        return view('depenses.index', compact('depenses', 'categories', 'totalMois', 'mois'));
    }

    public function create(): View
    {
        $categories = CategorieDepense::orderBy('nom')->get();

        return view('depenses.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $this->valider($request);

        if ($request->hasFile('justificatif')) {
            $donnees['justificatif_path'] = $request->file('justificatif')->store('depenses', 'public');
        }
        unset($donnees['justificatif']);

        $donnees['enregistre_par'] = $request->user()->id;

        Depense::create($donnees);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée avec succès !');
    }

    public function edit(Depense $depense): View
    {
        $categories = CategorieDepense::orderBy('nom')->get();

        return view('depenses.edit', compact('depense', 'categories'));
    }

    public function update(Request $request, Depense $depense): RedirectResponse
    {
        $donnees = $this->valider($request);

        if ($request->hasFile('justificatif')) {
            if ($depense->justificatif_path) {
                Storage::disk('public')->delete($depense->justificatif_path);
            }
            $donnees['justificatif_path'] = $request->file('justificatif')->store('depenses', 'public');
        }
        unset($donnees['justificatif']);

        $depense->update($donnees);

        return redirect()->route('depenses.index')->with('success', 'Dépense modifiée avec succès !');
    }

    public function destroy(Depense $depense): RedirectResponse
    {
        if ($depense->justificatif_path) {
            Storage::disk('public')->delete($depense->justificatif_path);
        }

        $depense->delete();

        return redirect()->route('depenses.index')->with('success', 'Dépense supprimée avec succès !');
    }

    private function valider(Request $request): array
    {
        return $request->validate([
            'categorie_depense_id' => ['required', Rule::exists(CategorieDepense::class, 'id')],
            'montant' => ['required', 'integer', 'min:1'],
            'date_depense' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
            'justificatif' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);
    }
}