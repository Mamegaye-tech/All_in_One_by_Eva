@extends('layouts.app')

@section('title', 'Rapports')
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
    <div>
        <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                <i class="fa-solid fa-chart-line"></i>
            </span>
            Rapports
        </h1>
        <p class="mt-2 text-sm text-[#725d6d]">Suivi global des campagnes</p>
    </div>

    <!-- Statistiques globales -->
    <div class="st-cards">
        <div class="st-card st-card-1">
            <span class="st-ico"><i class="fa-solid fa-bullhorn"></i></span>
            <div>
                <p class="st-label">Campagnes</p>
                <p class="st-nombre">{{ $campagnes->count() }}</p>
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

    <!-- Tableau par campagne -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="whitespace-nowrap px-6 py-4">Campagne</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Créée le</th>
                    <th class="whitespace-nowrap px-6 py-4">Destinataires</th>
                    <th class="whitespace-nowrap px-6 py-4">Suivis</th>
                    <th class="whitespace-nowrap px-6 py-4">Avancement</th>
                    <th class="whitespace-nowrap px-6 py-4 text-right">Détail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($campagnes as $campagne)
                    @php
                        $taux = $campagne->destinataires_count > 0
                            ? round($campagne->suivis_count / $campagne->destinataires_count * 100)
                            : 0;
                    @endphp
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="px-6 py-4 font-semibold">{{ $campagne->titre }}</td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">
                            {{ $campagne->created_at?->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">{{ $campagne->destinataires_count }}</td>
                        <td class="px-6 py-4">{{ $campagne->suivis_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="st-badge {{ $taux >= 50 ? 'st-badge-ok' : 'st-badge-bas' }}">
                                {{ $taux }} %
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('campagnes.show', $campagne) }}"
                               class="text-[#950e45] hover:underline">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fa-regular fa-folder-open mb-2 block text-2xl text-[#e8b5c6]"></i>
                            Aucune campagne pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection