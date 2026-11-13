@extends('layouts.app')

@section('title', 'Campagnes')
@section('sans_recherche', '1')

@section('content')
<div class="w-full space-y-6">

    <style>
        .st-cards { display:flex; flex-wrap:wrap; align-items:stretch; gap:14px; }
        .st-card { display:flex; align-items:center; gap:12px; min-width:190px; padding:12px 20px; border-radius:14px; box-shadow:0 4px 12px rgba(120,13,37,.12); }
        .st-card-1 { background:#f9dce9; }
        .st-card-2 { background:#f5bfd0; }
        .st-card-3 { background:#dfb3d7; }
        .st-ico { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:11px; font-size:18px; background:rgba(255,255,255,.55); color:#780d25; }
        .st-label { font-size:12px; font-weight:600; margin:0; color:#563b4c; }
        .st-nombre { font-size:22px; font-weight:800; line-height:1; margin:4px 0 0; color:#780d25; }
        .st-badge { display:inline-block; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600; }
        .st-badge-ok { background:#dcf7e6; color:#16894d; }
        .st-badge-bas { background:#fee2e2; color:#dc2626; }
    </style>

    <!-- En-tête -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                Campagnes
            </h1>
            <p class="mt-2 text-sm text-[#725d6d]">Envoyez des messages à vos clients et suivez les réponses.</p>
        </div>

        <a href="{{ route('campagnes.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#780d25] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#a51b56]">
            <i class="fa-solid fa-plus"></i> Nouvelle campagne
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-xl bg-green-100 px-4 py-2.5 text-sm font-semibold text-green-700">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Statistiques -->
    <div class="st-cards">
        <div class="st-card st-card-1">
            <span class="st-ico"><i class="fa-solid fa-bullhorn"></i></span>
            <div>
                <p class="st-label">Campagnes</p>
                <p class="st-nombre">{{ $totalCampagnes }}</p>
            </div>
        </div>
        <div class="st-card st-card-2">
            <span class="st-ico"><i class="fa-solid fa-users"></i></span>
            <div>
                <p class="st-label">Destinataires</p>
                <p class="st-nombre">{{ $totalDestinataires }}</p>
            </div>
        </div>
        <div class="st-card st-card-3">
            <span class="st-ico"><i class="fa-solid fa-circle-check"></i></span>
            <div>
                <p class="st-label">Suivis</p>
                <p class="st-nombre">{{ $totalSuivis }}</p>
            </div>
        </div>
    </div>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="whitespace-nowrap px-6 py-4">Campagne</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Modèle</th>
                    <th class="whitespace-nowrap px-6 py-4">Destinataires</th>
                    <th class="whitespace-nowrap px-6 py-4">Suivi</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Créée par</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 lg:table-cell">Date</th>
                    <th class="whitespace-nowrap px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($campagnes as $campagne)
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="px-6 py-4">
                            <a href="{{ route('campagnes.show', $campagne) }}"
                               class="text-base font-semibold hover:text-[#a51c50]">
                                {{ $campagne->titre }}
                            </a>
                        </td>
                        <td class="hidden px-6 py-4 text-[#725d6d] md:table-cell">
                            {{ $campagne->modele->titre ?? '—' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $campagne->destinataires_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($campagne->destinataires_count > 0 && $campagne->nb_suivis >= $campagne->destinataires_count)
                                <span class="st-badge st-badge-ok">Terminé</span>
                            @else
                                <span class="st-badge st-badge-bas">{{ $campagne->nb_suivis }}/{{ $campagne->destinataires_count }}</span>
                            @endif
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">{{ $campagne->creeParUser->name ?? '—' }}</td>
                        <td class="hidden whitespace-nowrap px-6 py-4 lg:table-cell">{{ $campagne->created_at?->format('d/m/Y') }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center justify-end gap-6 text-lg">
                                <a href="{{ route('campagnes.show', $campagne) }}" aria-label="Voir" title="Voir"
                                   class="text-[#a51c50] transition hover:scale-110">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('campagnes.destroy', $campagne) }}"
                                      onsubmit="return confirm('Supprimer cette campagne ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Supprimer" title="Supprimer"
                                            class="text-[#d9304f] transition hover:scale-110">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <i class="fa-regular fa-folder-open mb-2 block text-2xl text-[#e8b5c6]"></i>
                            Aucune campagne pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div>{{ $campagnes->links() }}</div>
</div>
@endsection