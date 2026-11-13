<?php

namespace App\Http\Controllers;

use App\Models\CampagneMessage;
use App\Models\Client;
use App\Models\DestinataireCampagne;
use App\Models\ModeleMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CampagneController extends Controller
{
    public function index(): View
    {
        $campagnes = CampagneMessage::with(['modele', 'creeParUser'])
            ->withCount([
                'destinataires',
                'destinataires as nb_suivis' => fn ($q) => $q->whereNotNull('suivi_manuel'),
            ])
            ->latest()
            ->paginate(10);

        $totalCampagnes = CampagneMessage::count();
        $totalDestinataires = DestinataireCampagne::count();
        $totalSuivis = DestinataireCampagne::whereNotNull('suivi_manuel')->count();

        return view('campagnes.index', compact('campagnes', 'totalCampagnes', 'totalDestinataires', 'totalSuivis'));
    }

    public function create(): View
    {
        $modeles = ModeleMessage::all();
        $clients = Client::where('statut', 'actif')->orderBy('nom')->orderBy('prenom')->get();

        return view('campagnes.create', compact('modeles', 'clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'titre' => ['required', 'string', 'max:150'],
            'modele_message_id' => ['nullable', Rule::exists(ModeleMessage::class, 'id')],
            'message' => ['required', 'string'],
            'clients' => ['required', 'array', 'min:1'],
            'clients.*' => [Rule::exists(Client::class, 'id')],
        ], [
            'clients.required' => 'Sélectionnez au moins un client.',
            'clients.min' => 'Sélectionnez au moins un client.',
        ]);

        $campagne = DB::transaction(function () use ($donnees, $request) {
            $campagne = CampagneMessage::create([
                'titre' => $donnees['titre'],
                'modele_message_id' => $donnees['modele_message_id'] ?? null,
                'message' => $donnees['message'],
                'cree_par' => $request->user()->id,
            ]);

            foreach (Client::whereIn('id', $donnees['clients'])->get() as $client) {
                DestinataireCampagne::create([
                    'campagne_message_id' => $campagne->id,
                    'client_id' => $client->id,
                    'message_personnalise' => str_replace(
                        ['{prenom}', '{nom}'],
                        [$client->prenom, $client->nom],
                        $donnees['message']
                    ),
                ]);
            }

            return $campagne;
        });

        return redirect()->route('campagnes.show', $campagne)
            ->with('success', 'Campagne créée avec succès.');
    }

    public function show(CampagneMessage $campagne): View
    {
        $campagne->load(['modele', 'creeParUser']);
        $destinataires = $campagne->destinataires()->with('client')->get();

        return view('campagnes.show', compact('campagne', 'destinataires'));
    }

    public function basculerSuivi(CampagneMessage $campagne, DestinataireCampagne $destinataire): RedirectResponse
    {
        abort_unless($destinataire->campagne_message_id === $campagne->id, 404);

        $destinataire->update(['suivi_manuel' => $destinataire->suivi_manuel ? null : 'suivi']);

        return back();
    }

    public function destroy(CampagneMessage $campagne): RedirectResponse
    {
        DB::transaction(function () use ($campagne) {
            $campagne->destinataires()->delete();
            $campagne->delete();
        });

        return redirect()->route('campagnes.index')
            ->with('success', 'Campagne supprimée.');
    }
}