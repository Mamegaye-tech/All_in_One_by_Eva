
@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<div class="w-full space-y-6">

    <!-- En-tête -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-semibold text-[#780D25]">
            Clients
        </h1>

        <div class="flex flex-wrap gap-2">
            @can('export', App\Models\Client::class)
                <a href="{{ route('clients.export', request()->query()) }}"
                   class="rounded-lg border border-[#780D25] px-4 py-2 text-sm text-[#780D25] hover:bg-white">
                    Exporter CSV
                </a>
            @endcan

            @can('create', App\Models\Client::class)
                <a href="{{ route('clients.create') }}"
                   class="rounded-lg bg-[#780D25] px-4 py-2 text-sm text-white hover:opacity-90">
                    + Nouveau client
                </a>
            @endcan
        </div>
    </div>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Recherche et filtres -->
    <form method="GET" action="{{ route('clients.index') }}"
          class="grid gap-3 rounded-xl bg-white p-4 shadow-sm sm:grid-cols-4">

        <input
            type="text"
            name="q"
            value="{{ $filtres['q'] ?? '' }}"
            placeholder="Nom ou téléphone..."
            class="rounded-lg border-gray-300 text-sm sm:col-span-2"
        >

        <select name="statut" class="rounded-lg border-gray-300 text-sm">
            <option value="">Tous les statuts</option>
            <option value="actif" @selected(($filtres['statut'] ?? '') === 'actif')>
                Actifs
            </option>
            <option value="inactif" @selected(($filtres['statut'] ?? '') === 'inactif')>
                Inactifs
            </option>
            <option value="archive" @selected(($filtres['statut'] ?? '') === 'archive')>
                Archivés
            </option>
        </select>

        <select name="consentement" class="rounded-lg border-gray-300 text-sm">
            <option value="">Consentement promo</option>
            <option value="oui" @selected(($filtres['consentement'] ?? '') === 'oui')>
                Accepté
            </option>
            <option value="non" @selected(($filtres['consentement'] ?? '') === 'non')>
                Non accepté
            </option>
        </select>

        <div class="flex gap-2 sm:col-span-4">
            <button type="submit"
                    class="rounded-lg bg-[#780D25] px-4 py-2 text-sm text-white">
                Filtrer
            </button>

            <a href="{{ route('clients.index') }}"
               class="rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                Réinitialiser
            </a>
        </div>
    </form>

    <!-- Tableau des clients -->
    <div class="overflow-x-auto rounded-xl bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm">

            <thead class="bg-[#F8F4F0] text-left text-xs uppercase tracking-wide text-[#780D25]">
                <tr>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Promo</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($clients as $client)
                    <tr class="hover:bg-[#F8F4F0]">

                        <td class="px-4 py-3 font-medium">
                            {{ $client->prenom }} {{ $client->nom }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $client->telephone }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $client->email ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $client->consentement_promo ? 'Oui' : 'Non' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs
                                {{ $client->statut === App\Enums\StatutClient::Actif
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-gray-200 text-gray-600' }}">
                                {{ $client->statut->label() }}
                            </span>
                        </td>

                        <td class="space-x-2 px-4 py-3 text-right">

                            <!-- Voir -->
                            <a href="{{ route('clients.show', $client) }}"
                               class="text-[#780D25] hover:underline">
                                Voir
                            </a>

                            <!-- WhatsApp -->
                            @if ($lien = $client->lienWhatsApp('Bonjour '.$client->prenom.' !'))
                                <a href="{{ $lien }}"
                                   target="_blank"
                                   rel="noopener"
                                   class="text-green-700 hover:underline">
                                    WhatsApp
                                </a>
                            @endif

                            <!-- Modifier -->
                            @can('update', $client)
                                <a href="{{ route('clients.edit', $client) }}"
                                   class="text-[#780D25] hover:underline">
                                    Modifier
                                </a>
                            @endcan

                            <!-- Archiver -->
                            @can('toggleStatus', $client)
                                @if ($client->statut !== App\Enums\StatutClient::Archive)
                                    <form method="POST"
                                          action="{{ route('clients.destroy', $client) }}"
                                          class="inline"
                                          onsubmit="return confirm('Archiver ce client ?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:underline">
                                            Archiver
                                        </button>
                                    </form>
                                @endif
                            @endcan

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6"
                            class="px-4 py-10 text-center text-gray-500">
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        {{ $clients->links() }}
    </div>

</div>
@endsection
