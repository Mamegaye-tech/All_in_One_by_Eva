@extends('layouts.app')
<<<<<<< HEAD

@section('title', 'Paramètres')
@section('sans_recherche', '1')

@section('content')
<div class="w-full space-y-6">

    <style>
        .pa-carte { background:#fff; border-radius:16px; box-shadow:0 3px 10px #e8d7df; padding:24px; width:fit-content; max-width:100%; }
        .pa-titre { display:flex; align-items:center; gap:10px; margin:0 0 18px; font-size:16px; font-weight:700; color:#780d25; }
        .pa-titre span { display:flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:10px; background:#f7d5e8; font-size:14px; }
        .pa-grille { display:grid; grid-template-columns:repeat(2, 260px); gap:18px 24px; }
        .pa-champ { display:flex; flex-direction:column; gap:6px; }
        .pa-champ-large { grid-column:1 / -1; }
        .pa-champ label { font-size:13px; font-weight:600; color:#725d6d; }
        .pa-champ input { width:100%; height:44px; box-sizing:border-box; padding:0 12px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; outline:none; background:#fff; }
        .pa-champ input:focus { border-color:#a01450; }
        .pa-erreur { font-size:12px; color:#dc2626; }
        .pa-actions { display:flex; justify-content:flex-end; }
        .pa-btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; height:44px; padding:0 28px; border-radius:10px; background:#780d25; color:#fff; font-size:14px; font-weight:600; border:0; cursor:pointer; }
        .pa-btn:hover { background:#a51b56; }
        @media (max-width:640px) { .pa-carte { width:auto; } .pa-grille { grid-template-columns:1fr; } }
    </style>

    <!-- En-tête -->
    <div>
        <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                <i class="fa-solid fa-gear"></i>
            </span>
            Paramètres
        </h1>
        <p class="mt-2 text-sm text-[#725d6d]">Informations et horaires de votre salon.</p>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2 rounded-xl bg-green-100 px-4 py-2.5 text-sm font-semibold text-green-700">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('parametres.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informations du salon -->
        <div class="pa-carte">
            <h2 class="pa-titre"><span><i class="fa-solid fa-store"></i></span> Informations du salon</h2>

            <div class="pa-grille">
                <div class="pa-champ pa-champ-large">
                    <label for="nom_salon">Nom du salon</label>
                    <input type="text" id="nom_salon" name="nom_salon" maxlength="150" required
                           value="{{ old('nom_salon', $parametres['nom_salon']) }}">
                    @error('nom_salon') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>

                <div class="pa-champ">
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" maxlength="30"
                           value="{{ old('telephone', $parametres['telephone']) }}">
                    @error('telephone') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>

                <div class="pa-champ">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" maxlength="150"
                           value="{{ old('email', $parametres['email']) }}">
                    @error('email') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>

                <div class="pa-champ pa-champ-large">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" maxlength="255"
                           value="{{ old('adresse', $parametres['adresse']) }}">
                    @error('adresse') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Horaires -->
        <div class="pa-carte">
            <h2 class="pa-titre"><span><i class="fa-regular fa-clock"></i></span> Horaires d'ouverture</h2>

            <div class="pa-grille">
                <div class="pa-champ">
                    <label for="heure_ouverture">Ouverture</label>
                    <input type="time" id="heure_ouverture" name="heure_ouverture" required
                           value="{{ old('heure_ouverture', substr($parametres['heure_ouverture'], 0, 5)) }}">
                    @error('heure_ouverture') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>

                <div class="pa-champ">
                    <label for="heure_fermeture">Fermeture</label>
                    <input type="time" id="heure_fermeture" name="heure_fermeture" required
                           value="{{ old('heure_fermeture', substr($parametres['heure_fermeture'], 0, 5)) }}">
                    @error('heure_fermeture') <span class="pa-erreur">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="pa-actions">
            <button type="submit" class="pa-btn">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </div>
    </form>
=======
@section('title', 'Paramètres')

@section('content')
@php
    $field = 'mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#780D25] focus:outline-none focus:ring-1 focus:ring-[#780D25]';
    $onglets = ['salon' => 'Informations du salon', 'messages' => 'Messages WhatsApp', 'regles' => 'Règles du salon'];
@endphp

<div class="mx-auto max-w-4xl space-y-6">
    <h1 class="text-2xl font-semibold text-[#780D25]">Paramètres</h1>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="flex gap-2 border-b border-gray-200">
        @foreach ($onglets as $cle => $label)
            <a href="{{ route('parametres.index', ['onglet' => $cle]) }}"
               class="px-4 py-2 text-sm {{ $onglet === $cle ? 'border-b-2 border-[#780D25] font-semibold text-[#780D25]' : 'text-gray-600 hover:text-[#780D25]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($onglet === 'salon')
        <form method="POST" action="{{ route('parametres.salon') }}" class="space-y-5 rounded-xl bg-white p-6 shadow-sm">
            @csrf @method('PUT')
            <div>
                <label class="text-sm font-medium">Nom du salon *</label>
                <input type="text" name="salon_nom" value="{{ old('salon_nom', $salon['salon_nom'] ?: 'All in One by Eva') }}" required class="{{ $field }}">
                @error('salon_nom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Téléphone</label>
                <input type="text" name="salon_telephone" value="{{ old('salon_telephone', $salon['salon_telephone']) }}" class="{{ $field }}">
                @error('salon_telephone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Adresse</label>
                <input type="text" name="salon_adresse" value="{{ old('salon_adresse', $salon['salon_adresse']) }}" class="{{ $field }}">
                @error('salon_adresse') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Horaires d'ouverture</label>
                <textarea name="salon_horaires" rows="3" placeholder="Ex. Lundi au samedi : 9h – 19h" class="{{ $field }}">{{ old('salon_horaires', $salon['salon_horaires']) }}</textarea>
                @error('salon_horaires') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="rounded-lg bg-[#780D25] px-5 py-2 text-sm text-white hover:opacity-90">Enregistrer</button>
        </form>
@elseif ($onglet === 'messages')
        <form method="POST" action="{{ route('parametres.messages') }}" class="space-y-6 rounded-xl bg-white p-6 shadow-sm">
            @csrf @method('PUT')
            <p class="text-sm text-gray-600">
                Variables disponibles :
                @foreach ($variables as $v)
                    <code class="rounded bg-[#F8F4F0] px-1.5 py-0.5">[{{ $v }}]</code>
                @endforeach
                Elles sont remplacées au moment de l'ouverture de WhatsApp. Vous relisez et envoyez le message vous-même.
            </p>

            @foreach (App\Enums\TypeMessage::cases() as $type)
                @php $m = $modeles[$type->value] ?? null; @endphp
                <div class="space-y-2 border-t border-gray-100 pt-4 first:border-0 first:pt-0">
                    <h2 class="font-semibold text-[#780D25]">{{ $type->label() }}</h2>
                    <input type="text" name="modeles[{{ $type->value }}][titre]"
                           value="{{ old("modeles.{$type->value}.titre", $m?->titre ?? $type->label()) }}" class="{{ $field }}">
                    @error("modeles.{$type->value}.titre") <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    <textarea name="modeles[{{ $type->value }}][contenu]" rows="4" class="{{ $field }}">{{ old("modeles.{$type->value}.contenu", $m?->contenu ?? $defauts[$type->value]) }}</textarea>
                    @error("modeles.{$type->value}.contenu") <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach

            <button type="submit" class="rounded-lg bg-[#780D25] px-5 py-2 text-sm text-white hover:opacity-90">Enregistrer les modèles</button>
        </form>
            @else
        <form method="POST" action="{{ route('parametres.regles') }}" class="space-y-5 rounded-xl bg-white p-6 shadow-sm">
            @csrf @method('PUT')
            <div>
                <label class="text-sm font-medium">Pause entre deux prestations (minutes)</label>
                <input type="number" min="0" max="120" name="pause_minutes" value="{{ old('pause_minutes', $regles['pause_minutes']) }}" class="{{ $field }}">
                @error('pause_minutes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Fidélité : FCFA dépensés pour gagner 1 point</label>
                <input type="number" min="1" name="fidelite_fcfa_par_point" value="{{ old('fidelite_fcfa_par_point', $regles['fidelite_fcfa_par_point']) }}" class="{{ $field }}">
                <p class="mt-1 text-xs text-gray-500">Seules les prestations payées donnent des points.</p>
                @error('fidelite_fcfa_par_point') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Client à relancer après (semaines sans visite)</label>
                <input type="number" min="1" max="52" name="inactivite_semaines" value="{{ old('inactivite_semaines', $regles['inactivite_semaines']) }}" class="{{ $field }}">
                @error('inactivite_semaines') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Offre d'anniversaire</label>
                <input type="text" name="offre_anniversaire" value="{{ old('offre_anniversaire', $regles['offre_anniversaire']) }}" placeholder="Ex. un soin du visage offert" class="{{ $field }}">
                @error('offre_anniversaire') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="rounded-lg bg-[#780D25] px-5 py-2 text-sm text-white hover:opacity-90">Enregistrer</button>
        </form>
    @endif
>>>>>>> dev-aboubacar
</div>
@endsection