<?php

namespace App\Http\Controllers;

use App\Enums\StatutRendezVous;
use App\Enums\ZoneSalon;
use App\Exceptions\RegleMetierException;
use App\Models\RendezVous;
use App\Services\RendezVousService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RendezVousController extends Controller
{
    public function __construct(private readonly RendezVousService $rendezVousService) {}

    public function index(Request $request)
    {
        $mois = Carbon::parse(($request->mois ?? now()->format('Y-m')) . '-01');
        $jour = Carbon::parse($request->jour ?? now()->toDateString());

        // Grille du calendrier : du lundi avant le 1er au dimanche après le dernier jour
        $debutGrille = $mois->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $finGrille = $mois->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // Jours qui ont au moins un rendez-vous (scopeEntre utilise "debut < fin")
        $joursAvecRdv = RendezVous::entre($debutGrille, $finGrille->copy()->addDay())
            ->get(['id', 'debut'])
            ->groupBy(fn ($r) => $r->debut->toDateString());

        // Liste du panneau de droite
        $rdvDuJour = RendezVous::with(['client', 'employe', 'lignes'])
            ->entre($jour->copy()->startOfDay(), $jour->copy()->addDay()->startOfDay())
            ->orderBy('debut')
            ->get();

        return view('rendez-vous.index', compact(
            'mois', 'jour', 'debutGrille', 'finGrille', 'joursAvecRdv', 'rdvDuJour'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'    => 'required|exists:clients,id',
            'employe_id'   => 'required|exists:employes,id',
            'date'         => 'required|date',
            'heure_debut'  => 'required|date_format:H:i',
            'zone'         => ['required', Rule::enum(ZoneSalon::class)],
            'services'     => 'nullable|array',
            'services.*'   => 'exists:services,id',
            'forfaits'     => 'nullable|array',
            'forfaits.*'   => 'exists:forfaits,id',
            'commentaire'  => 'nullable|string',
        ]);

        try {
            // Le service gère : conflits, durée, prix, lignes, audit
            $rdv = $this->rendezVousService->creer($data, $request->user());
        } catch (RegleMetierException $e) {
            return back()->withErrors(['regle' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('rendez-vous.index', [
                'jour' => $rdv->debut->toDateString(),
                'mois' => $rdv->debut->format('Y-m'),
            ])
            ->with('success', 'Rendez-vous créé.');
    }

    public function changerStatut(Request $request, RendezVous $rendezVous)
    {
        $data = $request->validate([
            'statut' => ['required', Rule::enum(StatutRendezVous::class)],
        ]);

        try {
            $this->rendezVousService->changerStatut($rendezVous, StatutRendezVous::from($data['statut']));
        } catch (RegleMetierException $e) {
            return back()->withErrors(['regle' => $e->getMessage()]);
        }

        return back()->with('success', 'Statut mis à jour.');
    }
}