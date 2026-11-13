@extends('layouts.app')

@section('title', 'Stock')
@section('sans_recherche', '1')

@section('content')
<div class="w-full space-y-6">

    <!-- En-tête -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>
                Stock
            </h1>
            <p class="mt-2 text-sm text-[#725d6d]">Suivez vos produits et leurs quantités.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-xl bg-green-100 px-4 py-2.5 text-sm font-semibold text-green-700">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl bg-red-100 px-4 py-2.5 text-sm text-red-700">
            @foreach ($errors->all() as $erreur)
                <div>{{ $erreur }}</div>
            @endforeach
        </div>
    @endif

    <style>
        .st-cards { display:flex; flex-wrap:wrap; align-items:stretch; gap:14px; }
        .st-card { display:flex; align-items:center; gap:12px; min-width:170px; padding:12px 20px; border-radius:14px; box-shadow:0 4px 12px rgba(120,13,37,.15); }
        .st-card-produits { background:linear-gradient(135deg,#780d25,#a01450); }
        .st-card-bas { background:#f7d5e8; border:2px solid #e8a9c8; }
        .st-ico { display:flex; align-items:center; justify-content:center; width:40px; height:40px; border-radius:11px; font-size:18px; }
        .st-card-produits .st-ico { background:rgba(255,255,255,.2); color:#fff; }
        .st-card-bas .st-ico { background:#780d25; color:#fbe2ed; }
        .st-label { font-size:12px; font-weight:600; margin:0; }
        .st-nombre { font-size:24px; font-weight:800; line-height:1; margin:4px 0 0; }
        .st-card-produits .st-label { color:#fbd5e5; }
        .st-card-produits .st-nombre { color:#fff; }
        .st-card-bas .st-label { color:#563b4c; }
        .st-card-bas .st-nombre { color:#780d25; }

        .st-filtres { display:flex; flex-wrap:nowrap; align-items:center; gap:12px; width:fit-content; max-width:100%; padding:16px; background:#fff; border:1px solid #f0dce6; border-radius:16px; }
        .st-recherche { position:relative; width:240px; flex:0 0 240px; margin-right:28px; }
        .st-recherche i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:14px; pointer-events:none; }
        .st-recherche input { width:100%; height:44px; box-sizing:border-box; padding:0 12px 0 42px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; outline:none; }
        .st-recherche input:focus { border-color:#a01450; }
        .st-ctrl { display:inline-flex; align-items:center; justify-content:center; height:44px; box-sizing:border-box; padding:0 20px; border-radius:10px; font-size:14px; white-space:nowrap; border:0; cursor:pointer; text-decoration:none; text-align:center; }
        .st-check { background:#fff8fb; color:#563b4c; gap:8px; border:1px solid #f0dce6; }
        .st-btn-filtrer { background:#780d25; color:#fff; font-weight:600; padding:0 28px; }
        .st-btn-filtrer:hover { background:#a51b56; }
        .st-btn-reset { background:#f3f4f6; color:#4b5563; }
        .st-btn-reset:hover { background:#e5e7eb; }
        .st-badge { display:inline-block; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600; }
        .st-badge-ok { background:#dcf7e6; color:#16894d; }
        .st-badge-bas { background:#fee2e2; color:#dc2626; }
        .st-badge-rupture { background:#fecaca; color:#991b1b; }
        @media (max-width:760px) {
            .st-filtres { flex-wrap:wrap; width:auto; }
            .st-recherche { flex:1 1 100%; width:100%; margin-right:0; }
        }
    </style>

    <!-- Statistiques -->
    <div class="st-cards">
        <div class="st-card st-card-produits">
            <span class="st-ico"><i class="fa-solid fa-boxes-stacked"></i></span>
            <div>
                <p class="st-label">Produits</p>
                <p class="st-nombre">{{ $produits->total() }}</p>
            </div>
        </div>

        <div class="st-card st-card-bas">
            <span class="st-ico"><i class="fa-solid fa-triangle-exclamation"></i></span>
            <div>
                <p class="st-label">Stock bas</p>
                <p class="st-nombre">{{ $nbAlertes }}</p>
            </div>
        </div>

        @if ($nbAlertes > 0)
            <a href="{{ route('stock.index', ['alerte' => 1]) }}"
               class="flex items-center gap-2 self-center text-sm font-semibold text-[#a01450] hover:underline">
                Afficher les produits en alerte <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        @endif
    </div>

    <!-- Filtres -->
    <form method="GET" action="{{ route('stock.index') }}" class="st-filtres">
        <div class="st-recherche">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="q" value="{{ $recherche }}" placeholder="Rechercher...">
        </div>

        <label class="st-ctrl st-check">
            <input type="checkbox" name="alerte" value="1" @checked($alerteSeulement)>
            Stock bas uniquement
        </label>

        <button type="submit" class="st-ctrl st-btn-filtrer">Filtrer</button>

        <a href="{{ route('stock.index') }}" class="st-ctrl st-btn-reset">Réinitialiser</a>
    </form>

    <!-- Tableau -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="whitespace-nowrap px-6 py-4">Produit</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Catégorie</th>
                    <th class="whitespace-nowrap px-6 py-4 font-semibold">Quantité</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 font-semibold lg:table-cell">Seuil</th>
                    <th class="whitespace-nowrap px-6 py-4">État</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 font-semibold lg:table-cell">Prix d'achat</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 font-semibold md:table-cell">Prix de vente</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 lg:table-cell">Fournisseur</th>
                    <th class="whitespace-nowrap px-6 py-4 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($produits as $produit)
                    @php $bas = $produit->quantite <= $produit->seuil_alerte; @endphp
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="px-6 py-4">{{ $produit->nom }}</td>
                        <td class="hidden px-6 py-4 md:table-cell">
                            @if ($produit->categorie)
                                <span class="rounded-full bg-[#f7d5e8] px-2.5 py-1 text-xs font-semibold text-[#a01450]">
                                    {{ $produit->categorie }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold {{ $bas ? 'text-red-600' : 'text-[#780d25]' }}">
                            {{ number_format($produit->quantite, 2, ',', ' ') }} {{ $produit->unite }}
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 text-[#725d6d] lg:table-cell">
                            {{ number_format($produit->seuil_alerte, 2, ',', ' ') }} {{ $produit->unite }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($produit->quantite <= 0)
                                <span class="st-badge st-badge-rupture">Rupture</span>
                            @elseif ($bas)
                                <span class="st-badge st-badge-bas">Stock bas</span>
                            @else
                                <span class="st-badge st-badge-ok">OK</span>
                            @endif
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 lg:table-cell">
                            {{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">
                            {{ $produit->prix_vente !== null ? number_format($produit->prix_vente, 0, ',', ' ') . ' FCFA' : '—' }}
                        </td>
                        <td class="hidden px-6 py-4 text-[#725d6d] lg:table-cell">{{ $produit->fournisseur ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <button type="button"
                                    data-id="{{ $produit->id }}"
                                    data-nom="{{ $produit->nom }}"
                                    data-unite="{{ $produit->unite }}"
                                    onclick="ouvrirAjustement(this)"
                                    class="rounded-lg bg-[#fbe2ed] px-3 py-1.5 text-xs font-semibold text-[#950e45] hover:bg-[#f4bfd6]">
                                <i class="fa-solid fa-sliders mr-1"></i> Ajuster
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-gray-500">
                            <i class="fa-regular fa-folder-open mb-2 block text-2xl text-[#e8b5c6]"></i>
                            Aucun produit trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div>{{ $produits->links() }}</div>
</div>

<!-- Fenêtre d'ajustement (HTML natif, sans Alpine) -->
<dialog id="dialogAjustement"
        class="m-auto w-full max-w-md rounded-2xl p-0 shadow-2xl backdrop:bg-black/40">
    <form method="POST" id="formAjustement" class="p-6">
        @csrf

        <h2 class="mb-4 text-lg font-bold text-[#780d25]">
            Ajuster le stock : <span id="ajustNom"></span>
        </h2>

        <div class="mb-3">
            <label class="mb-1 block text-sm font-semibold text-[#725d6d]">Type de mouvement</label>
            <select name="type" required
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-[#a01450] focus:outline-none">
                @foreach ($types as $type)
                    <option value="{{ $type->value }}">
                        {{ ucfirst(str_replace('_', ' ', $type->name)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="mb-1 block text-sm font-semibold text-[#725d6d]">
                Quantité <span id="ajustUnite"></span>
                <span class="font-normal text-gray-400">(+ entrée, − sortie)</span>
            </label>
            <input type="number" name="quantite" step="0.01" required
                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-[#a01450] focus:outline-none">
        </div>

        <div class="mb-5">
            <label class="mb-1 block text-sm font-semibold text-[#725d6d]">Motif</label>
            <input type="text" name="motif" maxlength="255" required
                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-[#a01450] focus:outline-none">
        </div>

        <div class="flex justify-end gap-2">
            <button type="button" onclick="document.getElementById('dialogAjustement').close()"
                    class="rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-600 hover:bg-gray-200">
                Annuler
            </button>
            <button type="submit"
                    class="rounded-lg bg-[#780d25] px-4 py-2 text-sm font-semibold text-white hover:bg-[#a51b56]">
                Enregistrer
            </button>
        </div>
    </form>
</dialog>

<script>
    function ouvrirAjustement(bouton) {
        const dialogue = document.getElementById('dialogAjustement');
        const formulaire = document.getElementById('formAjustement');

        formulaire.action = "{{ url('stock') }}/" + bouton.dataset.id + "/mouvement";
        document.getElementById('ajustNom').textContent = bouton.dataset.nom;
        document.getElementById('ajustUnite').textContent = bouton.dataset.unite ? '(' + bouton.dataset.unite + ')' : '';

        formulaire.reset();
        dialogue.showModal();
    }
</script>
@endsection