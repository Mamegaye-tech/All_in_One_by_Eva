@extends('layouts.app')

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
</div>
@endsection