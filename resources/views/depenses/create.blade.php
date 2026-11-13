@extends('layouts.app')

@section('sans_recherche', '1')

@section('title', 'Nouvelle dépense')

@section('content')
<div class="mx-auto max-w-3xl rounded-2xl bg-white p-6 shadow">
    <h1 class="mb-6 text-xl font-bold text-[#780d25]">Nouvelle dépense</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-100 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('depenses.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-semibold text-[#780d25]">Catégorie</label>
                <select name="categorie_depense_id" required class="w-full rounded-xl border border-gray-200 px-3 py-2">
                    <option value="">Choisir...</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" @selected(old('categorie_depense_id') == $categorie->id)>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-[#780d25]">Montant (FCFA)</label>
                <input type="number" name="montant" min="1" required value="{{ old('montant') }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-[#780d25]">Date</label>
                <input type="date" name="date_depense" required
                       value="{{ old('date_depense', now()->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-[#780d25]">Justificatif (jpg, png, pdf)</label>
                <input type="file" name="justificatif" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-semibold text-[#780d25]">Description</label>
                <textarea name="description" rows="3"
                          class="w-full rounded-xl border border-gray-200 px-3 py-2">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-xl bg-[#780d25] px-5 py-3 text-sm font-semibold text-white hover:opacity-90">
                Enregistrer
            </button>
            <a href="{{ route('depenses.index') }}" class="rounded-xl bg-gray-100 px-5 py-3 text-sm text-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection