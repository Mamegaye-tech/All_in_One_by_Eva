<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Afficher la liste des clients
    public function index(Request $request)
    {
        $clients = Client::query()
            ->nonArchives()
            ->recherche($request->search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    // Afficher le formulaire d'ajout
    public function create()
    {
        return view('clients.create');
    }

    // Enregistrer un nouveau client
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:clients,telephone',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_naissance' => 'nullable|date',
            'date_inscription' => 'required|date',
            'preference_communication' => 'required|string|max:20',
            'consentement_promo' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['consentement_promo'] = $request->boolean('consentement_promo');

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client ajouté avec succès.');
    }

    // Afficher les détails d'un client
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    // Afficher le formulaire de modification
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // Modifier un client
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|unique:clients,telephone,' . $client->id,
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_naissance' => 'nullable|date',
            'date_inscription' => 'required|date',
            'preference_communication' => 'required|string|max:20',
            'consentement_promo' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['consentement_promo'] = $request->boolean('consentement_promo');

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client modifié avec succès.');
    }

    // Archiver un client
    public function destroy(Client $client)
    {
        $client->update([
            'statut' => 'archive',
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Client archivé avec succès.');
    }
}
