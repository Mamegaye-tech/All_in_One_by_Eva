<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipeController extends Controller
{
    private function regles(): array
    {
        return [
            'prenom' => ['required', 'string', 'max:100'],
            'nom' => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'fonction' => ['nullable', 'string', 'max:100'],
            'specialites' => ['nullable', 'string'],
            'taux_commission' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function index(): View
    {
        $employes = Employe::orderBy('nom')->orderBy('prenom')->get();

        return view('equipe.index', compact('employes'));
    }

    public function create(): View
    {
        return view('equipe.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate($this->regles());
        $donnees['is_active'] = $request->boolean('is_active');

        Employe::create($donnees);

        return redirect()->route('equipe.index')
            ->with('success', 'Membre ajouté avec succès.');
    }

    public function edit(Employe $employe): View
    {
        return view('equipe.edit', compact('employe'));
    }

    public function update(Request $request, Employe $employe): RedirectResponse
    {
        $donnees = $request->validate($this->regles());
        $donnees['is_active'] = $request->boolean('is_active');

        $employe->update($donnees);

        return redirect()->route('equipe.index')
            ->with('success', 'Membre modifié.');
    }

    public function destroy(Employe $employe): RedirectResponse
    {
        $employe->delete();

        return redirect()->route('equipe.index')
            ->with('success', 'Membre supprimé.');
    }
}