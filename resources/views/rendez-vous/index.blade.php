@extends('layouts.app')


@section('search_action', route('rendez-vous.index'))
@section('search_placeholder', 'Rechercher un rendez-vous...')

@section('content')
@php
    $couleurs = [
        'amber' => 'bg-[#e8923a]',
        'sky' => 'bg-[#3a9ad9]',
        'violet' => 'bg-[#7b3fa0]',
        'emerald' => 'bg-[#2e9e6b]',
        'stone' => 'bg-[#9a8f94]',
    ];
    $champ = 'mt-1 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-[#a51c50] focus:outline-none focus:ring-1 focus:ring-[#a51c50]';
    $label = 'mt-3 block text-sm font-medium text-[#321b25]';
    $erreur = 'mt-1 text-sm text-red-600';
@endphp

<div class="grid grid-cols-1 gap-6 text-[#321b25] xl:grid-cols-[1fr_320px]">

    {{-- EN-TÊTE --}}
    <div class="flex flex-wrap items-center justify-between gap-4 xl:col-span-2">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#f8d5e2] text-xl text-[#a51c50]">
                <i class="fa-solid fa-gift"></i>
            </span>
            <div>
                <h1 class="text-2xl font-bold">Gestion des rendez-vous</h1>
                <p class="text-sm text-[#806d76]">Planifiez et suivez vos rendez-vous.</p>
            </div>
        </div>

        <button type="button"
                onclick="document.getElementById('modal-rdv').showModal()"
                class="rounded-xl bg-[#a51c50] px-6 py-3 font-semibold text-white shadow-md transition hover:bg-[#8e1646]">
            <i class="fa-solid fa-plus mr-2"></i>Nouveau rendez-vous
        </button>
    </div>

    @if (session('success'))
        <p class="rounded-lg bg-emerald-50 px-4 py-2 text-sm text-emerald-700 xl:col-span-2">{{ session('success') }}</p>
    @endif

    @if (session('success'))
    <p class="rounded-lg bg-emerald-50 px-4 py-2 text-sm text-emerald-700 xl:col-span-2">{{ session('success') }}</p>
@endif

{{-- AJOUTER ICI : le bloc des résultats --}}
@if ($resultats !== null)
    <section class="rounded-2xl bg-white p-6 shadow-[0_3px_10px_#e8d7df] xl:col-span-2">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold">Résultats pour « {{ $recherche }} »</h3>
                <p class="text-sm text-[#806d76]">{{ $resultats->total() }} rendez-vous trouvé(s), toutes dates confondues.</p>
            </div>
            <a href="{{ route('rendez-vous.index') }}"
               class="rounded-lg bg-[#f5edf1] px-5 py-2 text-sm font-medium transition hover:bg-[#f0dfe7]">
                <i class="fa-solid fa-xmark mr-1"></i>Effacer la recherche
            </a>
        </div>

        <div class="mt-5 divide-y divide-[#f0dfe7]">
            @forelse ($resultats as $rdv)
                <a href="{{ route('rendez-vous.index', ['mois' => $rdv->debut->format('Y-m'), 'jour' => $rdv->debut->toDateString()]) }}"
                   class="flex items-center gap-4 py-3 transition hover:bg-[#fff8fb]">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $couleurs[$rdv->statut->tone()] }}"></span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold">
                            {{ $rdv->debut->locale('fr')->translatedFormat('D j F Y') }} à {{ $rdv->debut->format('H:i') }}
                            – {{ $rdv->libellePrestations() ?: 'Sans prestation' }}
                        </p>
                        <p class="text-xs text-[#806d76]">
                            {{ $rdv->client?->nom_complet ?: 'Client' }}
                            @if ($rdv->employe) · avec {{ $rdv->employe->nom_complet }} @endif
                        </p>
                    </div>
                    <span class="text-xs font-medium text-[#806d76]">{{ $rdv->statut->label() }}</span>
                </a>
            @empty
                <p class="py-4 text-sm text-[#806d76]">Aucun rendez-vous trouvé pour cette recherche.</p>
            @endforelse
        </div>

        @if ($resultats->hasPages())
            <div class="mt-4 flex items-center justify-between text-sm">
                @if ($resultats->onFirstPage())
                    <span class="text-gray-300">← Précédent</span>
                @else
                    <a href="{{ $resultats->previousPageUrl() }}" class="text-[#780d25]">← Précédent</a>
                @endif

                <span class="text-[#806d76]">Page {{ $resultats->currentPage() }} / {{ $resultats->lastPage() }}</span>

                @if ($resultats->hasMorePages())
                    <a href="{{ $resultats->nextPageUrl() }}" class="text-[#780d25]">Suivant →</a>
                @else
                    <span class="text-gray-300">Suivant →</span>
                @endif
            </div>
        @endif
    </section>
@endif

@if ($resultats === null)

    {{-- CALENDRIER --}}
    <section class="rounded-2xl bg-white p-6 shadow-[0_3px_10px_#e8d7df]">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('rendez-vous.index', ['mois' => $mois->copy()->subMonth()->format('Y-m')]) }}"
                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5edf1] transition hover:bg-[#f0dfe7]">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
                <span class="text-lg font-bold">{{ ucfirst($mois->copy()->locale('fr')->translatedFormat('F Y')) }}</span>
                <a href="{{ route('rendez-vous.index', ['mois' => $mois->copy()->addMonth()->format('Y-m')]) }}"
                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f5edf1] transition hover:bg-[#f0dfe7]">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </div>

            <div class="flex gap-2">
                <a href="#" class="rounded-lg bg-[#f5edf1] px-5 py-2 text-sm font-medium transition hover:bg-[#f0dfe7]">Jour</a>
                <a href="#" class="rounded-lg bg-[#f5edf1] px-5 py-2 text-sm font-medium transition hover:bg-[#f0dfe7]">Semaine</a>
                <a href="#" class="rounded-lg bg-[#780d25] px-5 py-2 text-sm font-medium text-white">Mois</a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-7 gap-y-3 text-center">
            @foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $n)
                <div class="pb-2 text-sm font-semibold text-[#806d76]">{{ $n }}</div>
            @endforeach

            @for ($d = $debutGrille->copy(); $d <= $finGrille; $d->addDay())
                @php
                    $estAujourdhui = $d->isToday();
                    $estChoisi = $d->isSameDay($jour);
                    $autreMois = $d->month != $mois->month;
                @endphp
                <a href="{{ route('rendez-vous.index', ['mois' => $mois->format('Y-m'), 'jour' => $d->toDateString()]) }}"
                   @class([
                       'relative mx-auto flex h-11 w-11 items-center justify-center rounded-full text-base transition',
                       'bg-[#780d25] font-bold text-white' => $estAujourdhui,
                       'hover:bg-[#f5edf1]' => ! $estAujourdhui,
                       'text-gray-300' => $autreMois && ! $estAujourdhui,
                       'ring-2 ring-[#a51c50] ring-offset-2' => $estChoisi && ! $estAujourdhui,
                   ])>
                    {{ $d->day }}
                    @if ($joursAvecRdv->has($d->toDateString()))
                        <span @class([
                            'absolute bottom-1 h-1.5 w-1.5 rounded-full',
                            'bg-white' => $estAujourdhui,
                            'bg-[#a51c50]' => ! $estAujourdhui,
                        ])></span>
                    @endif
                </a>
            @endfor
        </div>
    </section>

    {{-- RENDEZ-VOUS DU JOUR --}}
    <aside class="rounded-2xl bg-white p-6 shadow-[0_3px_10px_#e8d7df]">
        <h3 class="text-lg font-bold">Rendez-vous du jour</h3>
        <p class="text-sm text-[#806d76]">{{ $jour->copy()->locale('fr')->translatedFormat('l j F Y') }}</p>

        <div class="mt-5 space-y-5">
            @forelse ($rdvDuJour as $rdv)
                <div class="flex gap-3">
                    <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ $couleurs[$rdv->statut->tone()] }}"></span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold">
                            {{ $rdv->debut->format('H:i') }} – {{ $rdv->libellePrestations() ?: 'Sans prestation' }}
                        </p>
                        <p class="text-xs text-[#806d76]">Avec {{ $rdv->client?->nom_complet ?: 'Client' }}</p>

                        <form method="POST" action="{{ route('rendez-vous.statut', $rdv) }}" class="mt-1">
                            @csrf
                            @method('PATCH')
                            <select name="statut" onchange="this.form.submit()"
                                    class="rounded-md border border-gray-200 bg-white px-2 py-1 text-xs focus:border-[#a51c50] focus:outline-none">
                                @foreach (\App\Enums\StatutRendezVous::cases() as $st)
                                    <option value="{{ $st->value }}" @selected($rdv->statut === $st)>{{ $st->label() }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-[#806d76]">Aucun rendez-vous ce jour.</p>
            @endforelse
        </div>
    </aside>
    @endif
</div>

{{-- FORMULAIRE NOUVEAU RENDEZ-VOUS --}}
<dialog id="modal-rdv" class="m-auto w-[min(92vw,460px)] rounded-2xl p-0 shadow-xl backdrop:bg-black/40">
    <form method="POST" action="{{ route('rendez-vous.store') }}" class="max-h-[90vh] overflow-y-auto p-6">
        @csrf
        <h3 class="text-xl font-bold">Nouveau rendez-vous</h3>

        @error('regle') <p class="{{ $erreur }}">{{ $message }}</p> @enderror

        <label class="{{ $label }}">Client</label>
        <select name="client_id" required class="{{ $champ }}">
            @foreach (\App\Models\Client::orderBy('nom')->get() as $c)
                <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->nom_complet }}</option>
            @endforeach
        </select>
        @error('client_id') <p class="{{ $erreur }}">{{ $message }}</p> @enderror

        <label class="{{ $label }}">Employé</label>
        <select name="employe_id" required class="{{ $champ }}">
            @foreach (\App\Models\Employe::orderBy('nom')->get() as $e)
                <option value="{{ $e->id }}" @selected(old('employe_id') == $e->id)>{{ $e->nom_complet }}</option>
            @endforeach
        </select>
        @error('employe_id') <p class="{{ $erreur }}">{{ $message }}</p> @enderror

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="{{ $label }}">Date</label>
                <input type="date" name="date" value="{{ old('date', $jour->toDateString()) }}" required class="{{ $champ }}">
                @error('date') <p class="{{ $erreur }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Heure de début</label>
                <input type="time" name="heure_debut" value="{{ old('heure_debut') }}" required class="{{ $champ }}">
                @error('heure_debut') <p class="{{ $erreur }}">{{ $message }}</p> @enderror
            </div>
        </div>

        <label class="{{ $label }}">Zone</label>
        <select name="zone" id="zone" required class="{{ $champ }}">
            @foreach (\App\Enums\ZoneSalon::cases() as $z)
                <option value="{{ $z->value }}" @selected(old('zone') == $z->value)>{{ $z->label() }}</option>
            @endforeach
        </select>
        @error('zone') <p class="{{ $erreur }}">{{ $message }}</p> @enderror

        <label class="{{ $label }}">Prestations</label>
        <select name="services[]" id="services" multiple class="{{ $champ }} h-28">
            @foreach (\App\Models\Service::actifs()->orderBy('nom')->get() as $s)
                <option value="{{ $s->id }}" data-zone="{{ $s->zone->value }}"
                        @selected(in_array($s->id, old('services', [])))>
                    {{ $s->nom }} – {{ number_format($s->prix, 0, ',', ' ') }} FCFA
                </option>
            @endforeach
        </select>
        @error('services') <p class="{{ $erreur }}">{{ $message }}</p> @enderror

        <label class="{{ $label }}">Forfaits</label>
        <select name="forfaits[]" multiple class="{{ $champ }} h-20">
            @foreach (\App\Models\Forfait::actifs()->orderBy('nom')->get() as $f)
                <option value="{{ $f->id }}" @selected(in_array($f->id, old('forfaits', [])))>
                    {{ $f->nom }} – {{ number_format($f->prix, 0, ',', ' ') }} FCFA
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-[#806d76]">
            Ctrl + clic pour en choisir plusieurs. Choisissez au moins une prestation ou un forfait. La fin et le prix sont calculés automatiquement.
        </p>

        <label class="{{ $label }}">Commentaire</label>
        <textarea name="commentaire" rows="2" class="{{ $champ }}">{{ old('commentaire') }}</textarea>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="this.closest('dialog').close()"
                    class="rounded-lg bg-[#f5edf1] px-5 py-2 text-sm font-medium transition hover:bg-[#f0dfe7]">
                Annuler
            </button>
            <button type="submit"
                    class="rounded-lg bg-[#a51c50] px-5 py-2 text-sm font-semibold text-white transition hover:bg-[#8e1646]">
                Enregistrer
            </button>
        </div>
    </form>
</dialog>

@if ($errors->any())
<script>document.getElementById('modal-rdv').showModal();</script>
@endif

<script>
    // N'affiche que les prestations de la zone choisie
    const zone = document.getElementById('zone');
    const services = document.getElementById('services');
    function filtrerServices() {
        [...services.options].forEach(o => {
            o.hidden = o.dataset.zone !== zone.value;
            if (o.hidden) o.selected = false;
        });
    }
    zone.addEventListener('change', filtrerServices);
    filtrerServices();
</script>
@endsection