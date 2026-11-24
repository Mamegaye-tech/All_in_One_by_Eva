<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
class CaisseController extends Controller
{
    public function index()
    {
        $operations = Caisse::orderByDesc('date')->get();
        $entrees = $operations->where('type', 'entree')->sum('montant');
        $sorties = $operations->where('type', 'sortie')->sum('montant');
        $solde = $entrees - $sorties;

        return view('caisse.index', compact('operations', 'entrees', 'sorties', 'solde'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'date'        => 'required|date',
        'designation' => 'required|string|max:255',
        'categorie'   => 'required|string|max:100',
        'type'        => 'required|in:entree,sortie',
        'montant'     => 'required|integer|min:0',
    ]);

    Caisse::create($data);

    return redirect()->route('caisse.index')->with('success', 'Opération ajoutée');
}

    public function destroy(Caisse $caisse)
    {
        $caisse->delete();

        return redirect()->route('caisse.index')->with('success', 'Opération supprimée');
    }
}