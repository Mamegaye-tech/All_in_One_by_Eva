@extends('layouts.app')

@section('title', 'Équipe')
@section('sans_recherche', '1')

@section('content')
<div class="w-full space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                <i class="fa-solid fa-user-group"></i>
            </span>
            Équipe
        </h1>
        <a href="{{ route('equipe.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#780d25] px-5 py-3 text-sm font-semibold text-white hover:opacity-90">
            <i class="fa-solid fa-plus"></i> Nouveau membre
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-xl bg-green-100 px-4 py-2.5 text-sm font-semibold text-green-700">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="px-6 py-4">Nom</th>
                    <th class="px-6 py-4">Fonction</th>
                    <th class="px-6 py-4">Téléphone</th>
                    <th class="px-6 py-4">Commission</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($employes as $employe)
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="px-6 py-4 font-semibold">{{ $employe->nom_complet }}</td>
                        <td class="px-6 py-4">{{ $employe->fonction ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $employe->telephone ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $employe->taux_commission !== null ? $employe->taux_commission . ' %' : '—' }}</td>
                        <td class="px-6 py-4">
                            @if ($employe->is_active)
                                <span class="inline-block rounded-full bg-[#dcf7e6] px-3 py-1 text-xs font-semibold text-[#16894d]">Actif</span>
                            @else
                                <span class="inline-block rounded-full bg-[#fee2e2] px-3 py-1 text-xs font-semibold text-[#dc2626]">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('equipe.edit', $employe) }}" class="text-[#950e45] hover:underline">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('equipe.destroy', $employe) }}"
                                      onsubmit="return confirm('Supprimer ce membre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fa-regular fa-folder-open mb-2 block text-2xl text-[#e8b5c6]"></i>
                            Aucun membre dans l'équipe.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection