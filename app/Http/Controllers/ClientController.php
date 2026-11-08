<?php

namespace App\Http\Controllers;

use App\Enums\StatutClient;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function __construct(private ClientService $service) {}

    // Afficher la liste des clients
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Client::class);

        $filtres = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'search' => ['nullable', 'string', 'max:100'],
            'statut' => ['nullable', 'in:actif,inactif,archive'],
            'consentement' => ['nullable', 'in:oui,non'],
        ]);

        // CompatibilitÃ© avec les deux versions de recherche
        if (!empty($filtres['search']) && empty($filtres['q'])) {
            $filtres['q'] = $filtres['search'];
        }

        $clients = Client::filtrer($filtres)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(15)
            ->withQueryString();

        return view('clients.index', compact('clients', 'filtres'));
    }

    // Afficher le formulaire d'ajout
    public function create()
    {
        Gate::authorize('create', Client::class);

        return view('clients.create', [
            'client' => new Client([
                'preference_communication' => 'whatsapp'
            ])
        ]);
    }

    // Enregistrer un nouveau client
    public function store(ClientRequest $request)
    {
        Gate::authorize('create', Client::class);

        $client = $this->service->create($request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', 'Client enregistrÃ© avec succÃ¨s.');
    }

    // Afficher les dÃ©tails d'un client
    public function show(Client $client)
    {
        Gate::authorize('view', $client);

        return view('clients.show', compact('client'));
    }

    // Afficher le formulaire de modification
    public function edit(Client $client)
    {
        Gate::authorize('update', $client);

        return view('clients.edit', compact('client'));
    }

    // Modifier un client
    public function update(ClientRequest $request, Client $client)
    {
        Gate::authorize('update', $client);

        $this->service->update($client, $request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', 'Fiche client mise Ã  jour.');
    }

    // Archiver un client
    public function destroy(Client $client)
    {
        Gate::authorize('toggleStatus', $client);

        $client->update([
            'statut' => 'archive',
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Client archivÃ© avec succÃ¨s.');
    }

    // Activer ou dÃ©sactiver un client
    public function toggleStatus(Client $client)
    {
        Gate::authorize('toggleStatus', $client);

        $this->service->toggleStatus($client);

        return back()->with(
            'success',
            $client->statut === StatutClient::Actif
                ? 'Client rÃ©activÃ©.'
                : 'Client dÃ©sactivÃ©.'
        );
    }

    // Exporter les clients en CSV
    public function export(Request $request)
    {
        Gate::authorize('export', Client::class);

        $filtres = $request->only([
            'q',
            'statut',
            'consentement'
        ]);

        return response()->streamDownload(function () use ($filtres) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'PrÃ©nom',
                'Nom',
                'TÃ©lÃ©phone',
                'WhatsApp',
                'E-mail',
                'Date de naissance',
                'Consentement promo',
                'Statut',
                'Inscription'
            ], ';');

            Client::filtrer($filtres)
                ->orderBy('nom')
                ->chunk(500, function ($clients) use ($out) {
                    foreach ($clients as $c) {
                        fputcsv($out, [
                            $this->csvSafe($c->prenom),
                            $this->csvSafe($c->nom),
                            '+'.$c->telephone,
                            $c->whatsapp ? '+'.$c->whatsapp : '',
                            $this->csvSafe($c->email),
                            $c->date_naissance?->format('d/m/Y') ?? '',
                            $c->consentement_promo ? 'Oui' : 'Non',
                            $c->statut->label(),
                            $c->date_inscription?->format('d/m/Y') ?? '',
                        ], ';');
                    }
                });

            fclose($out);
        }, 'clients-'.now()->format('Y-m-d').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8'
        ]);
    }

    /** Ã‰vite l'injection de formules dans Excel. */
    private function csvSafe(?string $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@]/', $value)
            ? "'".$value
            : $value;
    }
}
