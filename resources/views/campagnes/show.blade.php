<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
</div>
@extends('layouts.app')

@section('title', $campagne->titre)
@section('sans_recherche', '1')

@section('content')
@php
    $total = $destinataires->count();
    $suivis = $destinataires->whereNotNull('suivi_manuel')->count();

    // Lien WhatsApp : numéros à 9 chiffres => indicatif du Sénégal (221)
    $lienWhatsapp = function (?string $telephone, ?string $message) {
        $numero = preg_replace('/\D+/', '', (string) $telephone);
        if (strlen($numero) === 9) {
            $numero = '221' . $numero;
        }
        return 'https://wa.me/' . $numero . '?text=' . rawurlencode((string) $message);
    };
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
        .st-badge { display:inline-block; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600; }
        .st-badge-ok { background:#dcf7e6; color:#16894d; }
        .st-badge-bas { background:#fee2e2; color:#dc2626; }
        .cp-message { background:#fff; border-radius:16px; box-shadow:0 3px 10px #e8d7df; padding:20px 24px; }
        .cp-message p { white-space:pre-line; margin:6px 0 0; font-size:14px; color:#321b25; }
        .cp-btn-wa { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:10px; background:#dcf7e6; color:#16894d; font-size:12px; font-weight:600; text-decoration:none; }
        .cp-btn-wa:hover { background:#c3f0d4; }
        .cp-btn-suivi { display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:10px; background:#fbe2ed; color:#950e45; font-size:12px; font-weight:600; border:0; cursor:pointer; }
        .cp-btn-suivi:hover { background:#f4bfd6; }
    </style>

    <!-- En-tête -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="flex items-center gap-3 text-3xl font-bold text-[#780d25]">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7d5e8] text-lg shadow-sm">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                {{ $campagne->titre }}
            </h1>
            <p class="mt-2 text-sm text-[#725d6d]">
                Créée le {{ $campagne->created_at?->format('d/m/Y') }}
                @if ($campagne->creeParUser) par {{ $campagne->creeParUser->name }} @endif
            </p>
        </div>

        <a href="{{ route('campagnes.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-[#f3f4f6] px-5 py-3 text-sm text-gray-600 hover:bg-gray-200">
            <i class="fa-solid fa-arrow-left"></i> Retour
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
            <span class="st-ico"><i class="fa-solid fa-users"></i></span>
            <div>
                <p class="st-label">Destinataires</p>
                <p class="st-nombre">{{ $total }}</p>
            </div>
        </div>
        <div class="st-card st-card-2">
            <span class="st-ico"><i class="fa-solid fa-circle-check"></i></span>
            <div>
                <p class="st-label">Suivis</p>
                <p class="st-nombre">{{ $suivis }}</p>
            </div>
        </div>
        <div class="st-card st-card-3">
            <span class="st-ico"><i class="fa-solid fa-hourglass-half"></i></span>
            <div>
                <p class="st-label">Restants</p>
                <p class="st-nombre">{{ $total - $suivis }}</p>
            </div>
        </div>
    </div>

    <!-- Message -->
    <div class="cp-message">
        <p class="text-xs font-semibold text-[#806d76]">Message</p>
        <p>{{ $campagne->message }}</p>
    </div>

    <!-- Tableau des destinataires -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-[#fbeef3] text-sm font-semibold">
                <tr>
                    <th class="whitespace-nowrap px-6 py-4">Client</th>
                    <th class="whitespace-nowrap px-6 py-4">Téléphone</th>
                    <th class="whitespace-nowrap px-6 py-4">Suivi</th>
                    <th class="hidden whitespace-nowrap px-6 py-4 md:table-cell">Ouvert le</th>
                    <th class="whitespace-nowrap px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#f0dfe7] text-sm">
                @forelse ($destinataires as $destinataire)
                    <tr class="transition hover:bg-[#fffafc]">
                        <td class="px-6 py-4 font-semibold">{{ $destinataire->client->nom_complet ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $destinataire->client->telephone ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($destinataire->suivi_manuel)
                                <span class="st-badge st-badge-ok">Suivi</span>
                            @else
                                <span class="st-badge st-badge-bas">À suivre</span>
                            @endif
                        </td>
                        <td class="hidden whitespace-nowrap px-6 py-4 md:table-cell">
                            {{ $destinataire->ouvert_le?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                @if ($destinataire->client?->telephone)
                                    <a href="{{ $lienWhatsapp($destinataire->client->whatsapp ?: $destinataire->client->telephone, $destinataire->message_personnalise) }}"
                                       target="_blank" rel="noopener" class="cp-btn-wa">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif

                                <form method="POST"
                                      action="{{ route('campagnes.destinataires.suivi', [$campagne, $destinataire]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="cp-btn-suivi">
                                        <i class="fa-solid {{ $destinataire->suivi_manuel ? 'fa-rotate-left' : 'fa-check' }}"></i>
                                        {{ $destinataire->suivi_manuel ? 'Annuler' : 'Marquer suivi' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i class="fa-regular fa-folder-open mb-2 block text-2xl text-[#e8b5c6]"></i>
                            Aucun destinataire.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection