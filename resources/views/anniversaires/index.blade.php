@extends('layouts.app')

@section('title', 'Anniversaires')

@section('content')
@php
    $teintes = ['bg-[#e8b5c6]', 'bg-[#f3d3df]', 'bg-[#dfb3d7]', 'bg-[#f5bfd0]'];
@endphp

<div class="space-y-6 text-[#321b25]">

    {{-- EN-TÊTE --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#f8d5e2] text-xl text-[#a51c50]">
                <i class="fa-solid fa-cake-candles"></i>
            </span>
            <div>
                <h1 class="text-2xl font-bold">Anniversaires clients</h1>
                <p class="text-sm text-[#806d76]">Suivez les anniversaires de {{ $annee }} et les offres proposées.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('anniversaires.index') }}">
            <select name="mois" onchange="this.form.submit()"
                    class="rounded-xl border border-[#f0dfe7] bg-white px-4 py-3 font-semibold shadow-[0_3px_10px_#e8d7df] focus:outline-none focus:ring-2 focus:ring-[#a51c50]">
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" @selected($m === $mois)>
                        {{ ucfirst(\Carbon\Carbon::create(null, $m, 1)->locale('fr')->translatedFormat('F')) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if (session('success'))
        <p class="rounded-lg bg-emerald-50 px-4 py-2 text-sm text-emerald-700">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p class="rounded-lg bg-red-50 px-4 py-2 text-sm text-[#d9304f]">{{ $errors->first() }}</p>
    @endif

    {{-- TABLEAU --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-[0_3px_10px_#e8d7df]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left">
                <thead class="bg-[#fbeef3] text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-4">Client</th>
                        <th class="px-6 py-4">Anniversaire</th>
                        <th class="px-6 py-4">Offre</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="w-44 px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#f0dfe7] text-sm">
                    @forelse ($clients as $client)
                        @php $traite = $traites->get($client->id); @endphp
                        <tr class="transition hover:bg-[#fffafc]">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full font-bold text-[#780d25] {{ $teintes[$client->id % count($teintes)] }}">
                                        {{ strtoupper(mb_substr($client->prenom, 0, 1) . mb_substr($client->nom, 0, 1)) }}
                                    </span>
                                    <div>
                                        <a href="{{ route('clients.show', $client) }}" class="text-base font-semibold hover:text-[#a51c50]">
                                            {{ $client->nom_complet }}
                                        </a>
                                        <p class="text-xs text-[#806d76]">{{ $client->telephone }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-base">
                                {{ \Carbon\Carbon::parse($client->date_naissance)->locale('fr')->translatedFormat('d F') }}
                            </td>

                            @if ($traite)
                                <td class="px-6 py-4 text-base">{{ $traite->offre ?? '—' }}</td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        <i class="fa-solid fa-check mr-1"></i>Traité
                                    </span>
                                    <p class="mt-1 text-xs text-[#806d76]">par {{ $traite->traite_par }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end">
                                        <form method="POST" action="{{ route('anniversaires.destroy', $traite) }}"
                                              onsubmit="return confirm('Retirer le statut traité ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" aria-label="Annuler" title="Annuler"
                                                    class="text-lg text-[#d9304f] transition hover:scale-110">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    <form id="form-{{ $client->id }}" method="POST" action="{{ route('anniversaires.store', $client) }}">
                                        @csrf
                                    </form>
                                    <input type="text" name="offre" form="form-{{ $client->id }}" placeholder="Offre proposée"
                                           class="w-full rounded-lg border border-[#f0dfe7] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#a51c50]">
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-[#fdf0dd] px-3 py-1 text-xs font-semibold text-[#e8923a]">À traiter</span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end">
                                        <button type="submit" form="form-{{ $client->id }}"
                                                class="rounded-xl bg-[#a51c50] px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:bg-[#8e1646]">
                                            <i class="fa-solid fa-check mr-1"></i>Marquer traité
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-[#806d76]">Aucun anniversaire ce mois-ci.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection