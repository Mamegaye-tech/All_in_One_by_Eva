@extends('layouts.app')
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
</div>
@endsection