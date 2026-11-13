@extends('layouts.app')

@section('title', 'Dépenses')
@section('sans_recherche', '1')

@section('content')
@php
    $nombre = $depenses->total();
    $moyenne = $nombre > 0 ? round($totalMois / $nombre) : 0;
@endphp

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

        .st-filtres { display:flex; flex-wrap:nowrap; align-items:flex-end; gap:12px; padding:16px; background:#fff; border:1px solid #f0dce6; border-radius:16px; width:fit-content; max-width:100%; }
        .st-champ { display:flex; flex-direction:column; gap:4px; }
        .st-champ label { font-size:12px; font-weight:600; color:#725d6d; }
        .st-champ input, .st-champ select { height:44px; box-sizing:border-box; padding:0 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; outline:none; background:#fff; }
        .st-champ input:focus, .st-champ select:focus { border-color:#a01450; }
        .st-champ-mois { width:180px; }
        .st-champ-cat { width:200px; margin-right:28px; }
        .st-champ-mois input, .st-champ-cat select { width:100%; }
        .st-ctrl { display:inline-flex; align-items:center; justify-content:center; height:44px; box-sizing:border-box; padding:0 20px; border-radius:10px; font-size:14px; white-space:nowrap; border:0; cursor:pointer; text-decoration:none; text-align:center; }
        .st-btn-filtrer { background:#780d25; color:#fff; font-weight:600; padding:0 28px; }
        .st-btn-filtrer:hover { background:#a51b56; }
        .st-btn-reset { background:#f3f4f6; color:#4b5563; }
        .st-btn-reset:hover { background:#e5e7eb; }
        @media (max-width:760px) {
            .st-filtres { flex-wrap:wrap; width:auto; }
            .st-champ-mois, .st-champ-cat { flex:1 1 100%; width:100%; margin-right:0; }
        }
    </style>

    <!-- En-tête -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                    <i class="fa-solid fa-sack-dollar"></i>
                </span>
                Dépenses
            </h1>
            <p class="mt-2 text-sm text-[#725d6d]">Suivez les dépenses du salon.</p>
        </div>

        <a href="{{ route('depenses.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#780d25] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#a51b56]">
            <i class="fa-solid fa-plus"></i> Ajouter
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
            <span class="st-ico"><i class="fa-solid fa-wallet"></i></span>
            <div>
                <p class="st-label">Total du mois</p>
                <p class="st-nombre">{{ number_format($totalMois, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <div class="st-card st-card-2">
            <span class="st-ico"><i class="fa-solid fa-receipt"></i></span>
            <div>
                <p class="st-label">Dépenses</p>
                <p class="st-nombre">{{ $nombre }}</p>
            </div>
        </div>

        <div class="st-card st-card-3">
            <span class="st-ico"><i class="fa-solid fa-chart-simple"></i></span>
            <div>
                <p class="st-label">Moyenne</p>
                <p class="st-nombre">{{ number_format($moyenne, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <form method="GET" class="st-filtres">
        <div class="st-champ st-champ-mois">
            <label>Mois</label>
            <input type="month" name="mois" value="{{ $mois }}">
        </div>

        <div class="st-champ st-champ-cat">
            <label>Catégorie</label>
            <select name="categorie">
                <option value="">Toutes</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="st-ctrl st-btn-filtrer">Filtrer</button>

        <a href="{{ route('depenses.index') }}" class="st-ctrl st-btn-reset">Réinitialiser</a>
    </form>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="whitespace-nowrap px-6 py-4">Date</th>
                    <th class="whitespace-nowrap px-6 py-4">Catégorie</th>
                    <th class="hidden px-6 py-4 sm:table-cell">Description</th>
                    <th class="whitespace-nowrap px-6 py-4">Montant</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Par</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Justificatif</th>
                    <th class="whitespace-nowrap px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($depenses as $depense)
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="whitespace-nowrap px-6 py-4">{{ $depense->date_depense->format('d/m/Y') }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="rounded-full bg-[#f7d5e8] px-2.5 py-1 text-xs font-semibold text-[#a01450]">
                                {{ $depense->categorie->nom ?? '—' }}
                            </span>
                        </td>
                        <td class="hidden max-w-[240px] truncate px-6 py-4 text-[#725d6d] sm:table-cell"
                            title="{{ $depense->description }}">
                            {{ $depense->description ?: '—' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-[#780d25]">
                            {{ number_format($depense->montant, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">
                            {{ $depense->auteur->name ?? '—' }}
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">
                            @if ($depense->justificatif_path)
                                <a href="{{ asset('storage/' . $depense->justificatif_path) }}" target="_blank"
                                   class="text-[#a01450] hover:underline">
                                    <i class="fa-solid fa-paperclip"></i> Voir
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center justify-end gap-6 text-lg">
                                <a href="{{ route('depenses.edit', $depense) }}" aria-label="Modifier" title="Modifier"
                                   class="text-[#e8923a] transition hover:scale-110">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('depenses.destroy', $depense) }}"
                                      onsubmit="return confirm('Supprimer cette dépense ?')">
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
                            Aucune dépense pour cette période.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div>{{ $depenses->links() }}</div>
</div>
@endsection