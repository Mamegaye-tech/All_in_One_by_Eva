@extends('layouts.app')

@section('content')
@php
    $teintes = ['bg-[#e8b5c6]', 'bg-[#f3d3df]', 'bg-[#dfb3d7]', 'bg-[#f5bfd0]'];
@endphp

<div class="space-y-6 text-[#321b25]">

    {{-- EN-TÊTE --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#f8d5e2] text-xl text-[#a51c50]">
                <i class="fa-solid fa-users"></i>
            </span>
            <div>
                <h1 class="text-2xl font-bold">Gestion des clients</h1>
                <p class="text-sm text-[#806d76]">Consultez et gérez tous vos clients.</p>
            </div>
        </div>

        <a href="{{ route('clients.create') }}"
           class="rounded-xl bg-[#a51c50] px-6 py-3 font-semibold text-white shadow-md transition hover:bg-[#8e1646]">
            <i class="fa-solid fa-plus mr-2"></i>Ajouter un client
        </a>
    </div>

    @if (session('success'))
        <p class="rounded-lg bg-emerald-50 px-4 py-2 text-sm text-emerald-700">{{ session('success') }}</p>
    @endif

    {{-- TABLEAU --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left">
                <thead class="bg-[#fbeef3] text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-4">Client</th>
                        <th class="px-6 py-4">Téléphone</th>
                        <th class="px-6 py-4">Date d'inscription</th>
                        <th class="w-32 px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#f0dfe7] text-sm">
                    @forelse ($clients as $client)
                        <tr class="transition hover:bg-[#fffafc]">
                            <td class="px-6 py-4">
                                <div class="flex items-center  gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full font-bold text-[#780d25] {{ $teintes[$client->id % count($teintes)] }}">
                                        {{ strtoupper(mb_substr($client->prenom, 0, 1) . mb_substr($client->nom, 0, 1)) }}
                                    </span>
                                    <div>
                                        <a href="{{ route('clients.show', $client) }}" class="text-base font-semibold hover:text-[#a51c50]">
                                            {{ $client->nom_complet }}
                                        </a>
                                        @if ($client->statut)
                                            <p class="text-xs text-[#806d76]">{{ ucfirst(str_replace('_', ' ', $client->statut->value)) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-base">{{ $client->telephone }}</td>

                            <td class="px-6 py-4 text-base">{{ $client->date_inscription?->format('d/m/Y') }}</td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-6 text-lg">
                                    <a href="{{ route('clients.edit', $client) }}" aria-label="Modifier" title="Modifier"
                                       class="text-[#e8923a] transition hover:scale-110">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                          onsubmit="return confirm('Archiver ce client ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Archiver" title="Archiver"
                                                class="text-[#d9304f] transition hover:scale-110">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-[#806d76]">Aucun client trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if ($clients instanceof \Illuminate\Pagination\LengthAwarePaginator && $clients->hasPages())
        <nav class="flex items-center justify-center gap-2" aria-label="Pagination">
            @if ($clients->onFirstPage())
                <span class="flex h-9 w-9 items-center justify-center text-gray-300"><i class="fa-solid fa-chevron-left text-xs"></i></span>
            @else
                <a href="{{ $clients->previousPageUrl() }}" class="flex h-9 w-9 items-center justify-center text-[#806d76] hover:text-[#a51c50]">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            @foreach ($clients->getUrlRange(1, $clients->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   @class([
                       'flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition',
                       'bg-[#a51c50] text-white shadow' => $page === $clients->currentPage(),
                       'hover:bg-[#f5edf1]' => $page !== $clients->currentPage(),
                   ])>{{ $page }}</a>
            @endforeach

            @if ($clients->hasMorePages())
                <a href="{{ $clients->nextPageUrl() }}" class="flex h-9 w-9 items-center justify-center text-[#806d76] hover:text-[#a51c50]">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="flex h-9 w-9 items-center justify-center text-gray-300"><i class="fa-solid fa-chevron-right text-xs"></i></span>
            @endif
        </nav>
    @endif
</div>
@endsection