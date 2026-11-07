@extends('layouts.app')
@section('title', $client->nom_complet)

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-[#780D25]">{{ $client->nom_complet }}</h1>
            <span class="mt-1 inline-block rounded-full px-2 py-1 text-xs {{ $client->statut === App\Enums\StatutClient::Actif ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                {{ $client->statut->label() }}
            </span>
        </div>
        <div class="flex flex-wrap gap-2">
            @if ($lien = $client->lienWhatsApp('Bonjour '.$client->prenom.' !'))
                <a href="{{ $lien }}" target="_blank" rel="noopener"
                   class="rounded-lg bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">Envoyer un message WhatsApp</a>
            @endif
            @can('update', $client)
                <a href="{{ route('clients.edit', $client) }}" class="rounded-lg border border-[#780D25] px-4 py-2 text-sm text-[#780D25]">Modifier</a>
            @endcan
            @can('toggleStatus', $client)
                @php $actif = $client->statut === App\Enums\StatutClient::Actif; @endphp
                <form method="POST" action="{{ route('clients.toggle-status', $client) }}"
                      onsubmit="return confirm('{{ $actif ? 'Désactiver' : 'Réactiver' }} ce client ?')">
                    @csrf @method('PATCH')
                    <button class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        {{ $actif ? 'Désactiver' : 'Réactiver' }}
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="grid gap-4 rounded-xl bg-white p-6 shadow-sm sm:grid-cols-2">
        <div><p class="text-xs text-gray-500">Téléphone</p><p>{{ $client->telephone_affiche }}</p></div>
        <div><p class="text-xs text-gray-500">WhatsApp</p><p>{{ $client->whatsapp_affiche }}</p></div>
        <div><p class="text-xs text-gray-500">E-mail</p><p>{{ $client->email ?? '—' }}</p></div>
        <div><p class="text-xs text-gray-500">Date de naissance</p><p>{{ $client->date_naissance?->translatedFormat('d F Y') ?? 'Non renseignée' }}</p></div>
        <div><p class="text-xs text-gray-500">Préférence de communication</p><p>{{ App\Http\Requests\ClientRequest::PREFERENCES[$client->preference_communication] ?? '—' }}</p></div>
        <div><p class="text-xs text-gray-500">Inscrit le</p><p>{{ $client->date_inscription?->format('d/m/Y') ?? '—' }}</p></div>
        <div>
            <p class="text-xs text-gray-500">Messages promotionnels</p>
            <p>
                {{ $client->consentement_promo ? 'Accepté' : 'Non accepté' }}
                @if ($client->consentement_modifie_le)
                    <span class="text-xs text-gray-500">(modifié le {{ $client->consentement_modifie_le->format('d/m/Y') }})</span>
                @endif
            </p>
        </div>
        <div><p class="text-xs text-gray-500">Préférences de prestations</p><p>{{ $client->preferences_prestations ?? '—' }}</p></div>
        <div class="sm:col-span-2"><p class="text-xs text-gray-500">Notes</p><p class="whitespace-pre-line">{{ $client->notes ?? '—' }}</p></div>
    </div>

    <p class="text-xs text-gray-500">L'historique des rendez-vous, des paiements et de la fidélité sera ajouté à cette fiche dans l'étape suivante.</p>
</div>
@endsection