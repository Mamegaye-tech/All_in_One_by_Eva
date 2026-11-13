<?php

namespace App\Http\Controllers;

use App\Models\ParametreSalon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParametreController extends Controller
{
    /** Clés des paramètres et valeur par défaut. */
    private const CHAMPS = [
        'nom_salon'       => '',
        'telephone'       => '',
        'email'           => '',
        'adresse'         => '',
        'heure_ouverture' => '08:00',
        'heure_fermeture' => '20:00',
    ];

    public function index(): View
    {
        $parametres = [];

        foreach (self::CHAMPS as $cle => $defaut) {
            $parametres[$cle] = ParametreSalon::get($cle, $defaut);
        }

        return view('parametres.index', compact('parametres'));
    }

    public function update(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom_salon'       => ['required', 'string', 'max:150'],
            'telephone'       => ['nullable', 'string', 'max:30'],
            'email'           => ['nullable', 'email', 'max:150'],
            'adresse'         => ['nullable', 'string', 'max:255'],
            'heure_ouverture' => ['required', 'date_format:H:i'],
            'heure_fermeture' => ['required', 'date_format:H:i', 'after:heure_ouverture'],
        ]);

        foreach (array_keys(self::CHAMPS) as $cle) {
            ParametreSalon::set($cle, $donnees[$cle] ?? null);
        }

        return redirect()->route('parametres.index')
            ->with('success', 'Paramètres enregistrés.');
    }
}