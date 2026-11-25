@extends('layouts.app')
@section('title', 'Équipe')

@section('content')
<div class="w-full space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-semibold text-[#780D25]">Équipe</h1>
        @can('create', App\Models\Employe::class)
            <a href="{{ route('employes.create') }}" class="rounded-lg bg-[#780D25] px-4 py-2 text-sm text-white hover:opacity-90">+ Nouvel employé</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <!-- <form method="GET" class="grid gap-3 rounded-xl bg-white p-4 shadow-sm sm:grid-cols-4">
        <input type="text" name="q" value="{{ $filtres['q'] ?? '' }}" placeholder="Nom ou fonction…"
               class="rounded-lg border border-gray-300 px-3 py-2 text-sm sm:col-span-2">
        <select name="statut" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">Tous les statuts</option>
            <option value="actif" @selected(($filtres['statut'] ?? '') === 'actif')>Actifs</option>
            <option value="inactif" @selected(($filtres['statut'] ?? '') === 'inactif')>Inactifs</option>
        </select>
        <div class="flex gap-2">
            <button class="rounded-lg bg-[#780D25] px-4 py-2 text-sm text-white">Filtrer</button>
            <a href="{{ route('employes.index') }}" class="rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-white">Réinitialiser</a>
        </div>
    </form> -->

    <div class="overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="w-full divide-y divide-gray-200 text-sm" style="width:100%">
            <thead class="bg-[#F8F4F0] text-left text-xs uppercase tracking-wide text-[#780D25]">
                <tr>
                    <th class="px-4 py-3">Employé</th>
                    <th class="px-4 py-3">Fonction</th>
                    <th class="px-4 py-3">Téléphone</th>
                    @can('voirCommissions', App\Models\Employe::class)
                        <th class="px-4 py-3">Commission</th>
                    @endcan
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($employes as $employe)
                    <tr class="hover:bg-[#F8F4F0]">
                        <td class="px-4 py-3 font-medium">
                            <a href="{{ route('employes.show', $employe) }}" class="text-gray-900 hover:text-[#780D25]">{{ $employe->nom_complet }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $employe->fonction }}</td>
                        <td class="px-4 py-3">+{{ $employe->telephone }}</td>
                        @can('voirCommissions', App\Models\Employe::class)
                            <td class="px-4 py-3">{{ $employe->taux_commission !== null ? $employe->taux_commission.' %' : '—' }}</td>
                        @endcan
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs {{ $employe->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                                {{ $employe->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="space-x-3 px-4 py-3 text-right">
                            <a href="{{ route('employes.show', $employe) }}" class="text-[#780D25] hover:underline">Voir</a>
                            @can('update', $employe)
                                <a href="{{ route('employes.edit', $employe) }}" class="text-[#780D25] hover:underline">Modifier</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">Aucun employé trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $employes->links() }}
</div>
@endsection