<?php

namespace App\Http\Controllers;

use App\Enums\StatutRendezVous;
use App\Http\Requests\EmployeRequest;
use App\Models\Employe;
use App\Models\Service;
use App\Services\EmployeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeController extends Controller
{
    public function __construct(private EmployeService $service) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Employe::class);

        $filtres = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'statut' => ['nullable', 'in:actif,inactif'],
        ]);

        $employes = Employe::query()
            ->when($filtres['q'] ?? null, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('prenom', 'like', "%{$q}%")
                        ->orWhere('nom', 'like', "%{$q}%")
                        ->orWhere('fonction', 'like', "%{$q}%");
                });
            })
            ->when(($filtres['statut'] ?? null) === 'actif', fn ($q) => $q->where('is_active', true))
            ->when(($filtres['statut'] ?? null) === 'inactif', fn ($q) => $q->where('is_active', false))
            ->orderBy('nom')->orderBy('prenom')
            ->paginate(15)
            ->withQueryString();

        return view('employes.index', compact('employes', 'filtres'));
    }

    public function create()
    {
        Gate::authorize('create', Employe::class);

        return view('employes.create', [
            'employe' => new Employe(),
            'services' => Service::orderBy('nom')->get(),
        ]);
    }

    public function store(EmployeRequest $request)
    {
        Gate::authorize('create', Employe::class);

        $employe = $this->service->create($this->donnees($request));

        return redirect()->route('employes.show', $employe)
            ->with('success', 'Employé enregistré, son compte de connexion est créé.');
    }

    public function show(Employe $employe)
    {
        Gate::authorize('view', $employe);

        $employe->load(['user.role', 'services', 'disponibilites']);

        $performance = null;

        if (Gate::allows('voirCommissions', Employe::class)) {
            $termines = $employe->rendezVous()
                ->where('statut', StatutRendezVous::Termine)
                ->whereBetween('debut', [now()->startOfMonth(), now()->endOfMonth()]);

            $nombre = (clone $termines)->count();
            $montant = (int) (clone $termines)->sum('prix_prevu');

            $performance = [
                'nombre' => $nombre,
                'montant' => $montant,
                'commission' => $employe->taux_commission !== null
                    ? round($montant * (float) $employe->taux_commission / 100)
                    : null,
            ];
        }

        return view('employes.show', compact('employe', 'performance'));
    }

    public function edit(Employe $employe)
    {
        Gate::authorize('update', $employe);

        $employe->load(['user', 'services', 'disponibilites']);

        return view('employes.edit', [
            'employe' => $employe,
            'services' => Service::orderBy('nom')->get(),
        ]);
    }

    public function update(EmployeRequest $request, Employe $employe)
    {
        Gate::authorize('update', $employe);

        $this->service->update($employe, $this->donnees($request));

        return redirect()->route('employes.show', $employe)
            ->with('success', 'Fiche employé mise à jour.');
    }

    public function toggleStatus(Employe $employe)
    {
        Gate::authorize('toggleStatus', $employe);

        if ($employe->user_id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $this->service->toggleStatus($employe);

        return back()->with('success', $employe->is_active ? 'Employé réactivé.' : 'Employé désactivé.');
    }

    /** Retire le taux de commission si l'utilisateur n'a pas le droit de le modifier. */
    private function donnees(EmployeRequest $request): array
    {
        $data = $request->validated();

        if (! Gate::allows('voirCommissions', Employe::class)) {
            unset($data['taux_commission']);
        }

        return $data;
    }
}