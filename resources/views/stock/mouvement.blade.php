
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Historique des mouvements</h1>
            <p class="text-gray-500 mt-1">
                Produit : {{ $produit->nom }}
            </p>
        </div>

        <a href="{{ route('stock.index') }}"
           class="text-blue-600 hover:underline">
            ← Retour au stock
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3 text-right">Quantité</th>
                    <th class="px-4 py-3 text-right">Stock après</th>
                    <th class="px-4 py-3">Motif</th>
                    <th class="px-4 py-3">Enregistré par</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($mouvements as $mouvement)
                    <tr>
                        <td class="px-4 py-3">
                            {{ $mouvement->created_at?->format('d/m/Y H:i') ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $mouvement->type->value }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ number_format($mouvement->quantite, 2, ',', ' ') }}
                            {{ $produit->unite }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ number_format($mouvement->stock_apres, 2, ',', ' ') }}
                            {{ $produit->unite }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $mouvement->motif }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $mouvement->auteur?->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Aucun mouvement enregistré pour ce produit.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-4">
        {{ $mouvements->links() }}
    </div>

</div>
@endsection
