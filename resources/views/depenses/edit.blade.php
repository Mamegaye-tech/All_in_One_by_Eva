@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la dépense</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('depenses.update', $depense) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="categorie_depense_id">Catégorie</label>
            <select name="categorie_depense_id" id="categorie_depense_id" class="form-select">
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}"
                        @selected(old('categorie_depense_id', $depense->categorie_depense_id) == $categorie->id)>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="montant">Montant</label>
            <input type="number" step="0.01" name="montant" id="montant" class="form-control"
                   value="{{ old('montant', $depense->montant) }}">
        </div>

        <div class="mb-3">
            <label for="date_depense">Date</label>
            <input type="date" name="date_depense" id="date_depense" class="form-control"
                   value="{{ old('date_depense', $depense->date_depense) }}">
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $depense->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="justificatif">Justificatif</label>
            <input type="file" name="justificatif" id="justificatif" class="form-control">
            @if ($depense->justificatif_path)
                <small>Fichier actuel : {{ basename($depense->justificatif_path) }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('depenses.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection