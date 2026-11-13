<div>
    <!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
</div>
@extends('layouts.app')

@section('title', 'Nouvelle campagne')
@section('sans_recherche', '1')

@section('content')
<div class="w-full space-y-6">

    <style>
        .cp-carte { background:#fff; border-radius:16px; box-shadow:0 3px 10px #e8d7df; padding:24px; }
        .cp-champ { display:flex; flex-direction:column; gap:6px; margin-bottom:18px; }
        .cp-champ label { font-size:13px; font-weight:600; color:#725d6d; }
        .cp-champ input[type=text], .cp-champ select, .cp-champ textarea { width:100%; box-sizing:border-box; padding:10px 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; outline:none; background:#fff; }
        .cp-champ input:focus, .cp-champ select:focus, .cp-champ textarea:focus { border-color:#a01450; }
        .cp-aide { font-size:12px; color:#806d76; }
        .cp-liste { max-height:280px; overflow-y:auto; border:1px solid #f0dce6; border-radius:10px; }
        .cp-ligne { display:flex; align-items:center; gap:10px; padding:10px 14px; border-bottom:1px solid #f6e9ef; font-size:14px; cursor:pointer; }
        .cp-ligne:last-child { border-bottom:0; }
        .cp-ligne:hover { background:#fffafc; }
        .cp-outils { display:flex; flex-wrap:wrap; align-items:center; gap:12px; margin-bottom:10px; }
        .cp-outils input { height:40px; padding:0 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; outline:none; width:240px; }
        .cp-lien { background:none; border:0; color:#a01450; font-size:13px; font-weight:600; cursor:pointer; }
        .cp-lien:hover { text-decoration:underline; }
        .cp-actions { display:flex; justify-content:flex-end; gap:12px; margin-top:8px; }
        .cp-btn { display:inline-flex; align-items:center; justify-content:center; height:44px; padding:0 26px; border-radius:10px; font-size:14px; border:0; cursor:pointer; text-decoration:none; }
        .cp-btn-ok { background:#780d25; color:#fff; font-weight:600; }
        .cp-btn-ok:hover { background:#a51b56; }
        .cp-btn-annuler { background:#f3f4f6; color:#4b5563; }
    </style>

    <!-- En-tête -->
    <div>
        <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                <i class="fa-solid fa-bullhorn"></i>
            </span>
            Nouvelle campagne
        </h1>
        <p class="mt-2 text-sm text-[#725d6d]">Rédigez un message et choisissez les clients à contacter.</p>
    </div>

    @if ($errors->any())
        <div class="rounded-xl bg-red-100 px-4 py-2.5 text-sm text-red-700">
            @foreach ($errors->all() as $erreur)
                <div>{{ $erreur }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('campagnes.store') }}" class="cp-carte">
        @csrf

        <div class="cp-champ">
            <label for="titre">Titre de la campagne</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" maxlength="150" required>
        </div>

        <div class="cp-champ">
            <label for="modele">Modèle de message (optionnel)</label>
            <select id="modele" name="modele_message_id">
                <option value="">— Aucun —</option>
                @foreach ($modeles as $modele)
                    <option value="{{ $modele->id }}"
                            data-contenu="{{ $modele->contenu ?? '' }}"
                            @selected(old('modele_message_id') == $modele->id)>
                        {{ $modele->titre ?? 'Modèle #' . $modele->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="cp-champ">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            <span class="cp-aide">Utilise {prenom} et {nom} pour personnaliser le message pour chaque client.</span>
        </div>

        <div class="cp-champ">
            <label>Destinataires</label>
            <div class="cp-outils">
                <input type="text" id="rechercheClient" placeholder="Rechercher un client...">
                <button type="button" class="cp-lien" id="toutSelectionner">Tout sélectionner</button>
                <button type="button" class="cp-lien" id="toutDeselectionner">Tout désélectionner</button>
                <span class="cp-aide" id="compteur">0 sélectionné</span>
            </div>

            <div class="cp-liste">
                @forelse ($clients as $client)
                    <label class="cp-ligne" data-nom="{{ mb_strtolower($client->nom_complet . ' ' . $client->telephone) }}">
                        <input type="checkbox" name="clients[]" value="{{ $client->id }}"
                               @checked(in_array($client->id, old('clients', [])))>
                        <span class="font-semibold">{{ $client->nom_complet }}</span>
                        <span class="text-[#806d76]">{{ $client->telephone }}</span>
                    </label>
                @empty
                    <p class="px-4 py-6 text-center text-sm text-gray-500">Aucun client disponible.</p>
                @endforelse
            </div>
        </div>

        <div class="cp-actions">
            <a href="{{ route('campagnes.index') }}" class="cp-btn cp-btn-annuler">Annuler</a>
            <button type="submit" class="cp-btn cp-btn-ok">Créer la campagne</button>
        </div>
    </form>
</div>

<script>
    const cases = () => document.querySelectorAll('.cp-ligne input[type=checkbox]');
    const compteur = document.getElementById('compteur');

    function majCompteur() {
        const n = [...cases()].filter(c => c.checked).length;
        compteur.textContent = n + (n > 1 ? ' sélectionnés' : ' sélectionné');
    }

    document.getElementById('modele').addEventListener('change', function () {
        const contenu = this.options[this.selectedIndex].dataset.contenu;
        if (contenu) document.getElementById('message').value = contenu;
    });

    document.getElementById('rechercheClient').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.cp-ligne').forEach(l => {
            l.style.display = l.dataset.nom.includes(q) ? '' : 'none';
        });
    });

    document.getElementById('toutSelectionner').addEventListener('click', () => {
        document.querySelectorAll('.cp-ligne').forEach(l => {
            if (l.style.display !== 'none') l.querySelector('input').checked = true;
        });
        majCompteur();
    });

    document.getElementById('toutDeselectionner').addEventListener('click', () => {
        cases().forEach(c => c.checked = false);
        majCompteur();
    });

    cases().forEach(c => c.addEventListener('change', majCompteur));
    majCompteur();
</script>
@endsection