@extends('layouts.app')
@section('title', $employe->nom_complet)

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-[#780D25]">{{ $employe->nom_complet }}</h1>
            <span class="mt-1 inline-block rounded-full px-2 py-1 text-xs {{ $employe->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                {{ $employe->is_active ? 'Actif' : 'Inactif' }}
            </span>
        </div>
        <div class="flex flex-wrap gap-2">
            @can('update', $employe)
                <a href="{{ route('employes.edit', $employe) }}" class="rounded-lg border border-[#780D25] px-4 py-2 text-sm text-[#780D25]">Modifier</a>
            @endcan
            @can('toggleStatus', $employe)
                <form method="POST" action="{{ route('employes.toggle-status', $employe) }}"
                      onsubmit="return confirm('{{ $employe->is_active ? 'Désactiver' : 'Réactiver' }} cet employé et son compte de connexion ?')">
                    @csrf @method('PATCH')
                    <button class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        {{ $employe->is_active ? 'Désactiver' : 'Réactiver' }}
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="grid gap-4 rounded-xl bg-white p-6 shadow-sm sm:grid-cols-2">
        <div><p class="text-xs text-gray-500">Fonction</p><p>{{ $employe->fonction }}</p></div>
        <div><p class="text-xs text-gray-500">Téléphone</p><p>+{{ $employe->telephone }}</p></div>
        <div><p class="text-xs text-gray-500">Spécialités</p><p>{{ $employe->specialites ?? '—' }}</p></div>
        <div>
            <p class="text-xs text-gray-500">Compte de connexion</p>
            <p>{{ $employe->user?->email ?? 'Aucun compte' }}
                @if ($employe->user?->role)
                    <span class="text-xs text-gray-500">({{ $employe->user->role->label }})</span>
                @endif
            </p>
        </div>
        @can('voirCommissions', App\Models\Employe::class)
            <div><p class="text-xs text-gray-500">Taux de commission</p><p>{{ $employe->taux_commission !== null ? $employe->taux_commission.' %' : '—' }}</p></div>
        @endcan
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <h2 class="mb-3 font-semibold text-[#780D25]">Prestations proposées</h2>
        @forelse ($employe->services as $service)
            <span class="mb-2 mr-2 inline-block rounded-full bg-[#F8F4F0] px-3 py-1 text-sm">{{ $service->nom }}</span>
        @empty
            <p class="text-sm text-gray-500">Aucune prestation attribuée.</p>
        @endforelse
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm">
        <h2 class="mb-3 font-semibold text-[#780D25]">Horaires de travail</h2>
        @php $dispos = $employe->disponibilites->keyBy('jour_semaine'); @endphp
        <ul class="space-y-1 text-sm">
            @foreach (App\Http\Requests\EmployeRequest::JOURS as $n => $label)
                <li class="flex gap-4">
                    <span class="w-28 text-gray-600">{{ $label }}</span>
                    @if ($d = $dispos[$n] ?? null)
                        <span>{{ substr($d->heure_debut, 0, 5) }} – {{ substr($d->heure_fin, 0, 5) }}</span>
                    @else
                        <span class="text-gray-400">Repos</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    @if ($performance)
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-1 font-semibold text-[#780D25]">Performance du mois</h2>
            <p class="mb-3 text-xs text-gray-500">Prestations terminées ce mois-ci. Les montants sont les prix prévus des rendez-vous, pas les encaissements réels.</p>
            <div class="grid gap-4 sm:grid-cols-3">
                <div><p class="text-xs text-gray-500">Prestations terminées</p><p class="text-lg font-semibold">{{ $performance['nombre'] }}</p></div>
                <div><p class="text-xs text-gray-500">Montant prévu</p><p class="text-lg font-semibold">{{ number_format($performance['montant'], 0, ',', ' ') }} FCFA</p></div>
                <div><p class="text-xs text-gray-500">Commission estimée</p>
                    <p class="text-lg font-semibold">{{ $performance['commission'] !== null ? number_format($performance['commission'], 0, ',', ' ').' FCFA' : '—' }}</p></div>
            </div>
        </div>
    @endif
</div>
@endsection