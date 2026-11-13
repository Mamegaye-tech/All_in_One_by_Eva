<?php

namespace App\Http\Controllers;

use App\Models\AnniversaireTraite;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnniversaireController extends Controller
{
    /**
     * Liste des anniversaires clients du mois, avec leur statut "traité" pour l'année en cours.
     */
    public function index(Request $request): View
    {
        $annee = now()->year;
        $mois = (int) $request->input('mois', now()->month);
        $mois = min(max($mois, 1), 12);

        $clients = Client::whereMonth('date_naissance', $mois)
            ->get()
            ->sortBy(fn (Client $c) => Carbon::parse($c->date_naissance)->day)
            ->values();

        $traites = AnniversaireTraite::where('annee', $annee)
            ->whereIn('client_id', $clients->pluck('id'))
            ->get()
            ->keyBy('client_id');

        return view('anniversaires.index', compact('clients', 'traites', 'annee', 'mois'));
    }

    /**
     * Marque l'anniversaire d'un client comme traité pour l'année en cours.
     */
    public function store(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'offre' => ['nullable', 'string', 'max:255'],
        ]);

        AnniversaireTraite::updateOrCreate(
            ['client_id' => $client->id, 'annee' => now()->year],
            ['offre' => $data['offre'] ?? null, 'traite_par' => $request->user()->name]
        );

        return back()->with('success', "Anniversaire de {$client->nom_complet} marqué comme traité.");
    }

    /**
     * Annule le statut "traité".
     */
    public function destroy(AnniversaireTraite $anniversaire): RedirectResponse
    {
        $anniversaire->delete();

        return back()->with('success', 'Le statut "traité" a été retiré.');
    }
}