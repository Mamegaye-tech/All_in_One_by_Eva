@extends('layouts.app')

@section('contenu')

<style>
    .form-page {
        background: #fff7fa;
        min-height: 100vh;
        padding: 25px 28px;
        color: #390c29;
    }

    .form-page h1 {
        font-size: 32px;
        font-weight: bold;
        color: #780d35;
        margin-bottom: 5px;
    }

    .form-page .sous-titre {
        color: #563b4c;
        margin-bottom: 30px;
    }

    .form-card {
        background: white;
        border: 1px solid #f0dce6;
        border-radius: 18px;
        padding: 30px;
        max-width: 800px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #f0dce6;
        border-radius: 12px;
        background: #fff7fa;
        outline: none;
        font-size: 15px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #780d35;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .erreur {
        color: #bd1a1a;
        font-size: 14px;
        margin-top: 5px;
    }

    .image-actuelle {
        width: 160px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 10px;
    }

    .btn-enregistrer {
        background: #780d35;
        color: white;
        padding: 14px 26px;
        border-radius: 13px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-enregistrer:hover {
        background: #a51b56;
    }

    .btn-annuler {
        display: inline-block;
        padding: 14px 26px;
        border-radius: 13px;
        background: #f9eaf1;
        color: #780d35;
        font-weight: 600;
        text-decoration: none;
        margin-left: 10px;
    }

    @media(max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-page">

    <h1><i class="fas fa-pen"></i> Modifier la prestation</h1>
    <p class="sous-titre">Modifiez les informations de « {{ $prestation->nom }} ».</p>

    <div class="form-card">

        <form action="{{ route('prestations.update', $prestation->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom de la prestation</label>
                <input type="text" id="nom" name="nom"
                       value="{{ old('nom', $prestation->nom) }}">
                @error('nom') <div class="erreur">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4">{{ old('description', $prestation->description) }}</textarea>
                @error('description') <div class="erreur">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <input type="text" id="categorie" name="categorie"
                       value="{{ old('categorie', $prestation->categorie) }}">
                @error('categorie') <div class="erreur">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="prix">Prix (FCFA)</label>
                    <input type="number" id="prix" name="prix" step="1" min="0"
                           value="{{ old('prix', $prestation->prix) }}">
                    @error('prix') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="duree">Durée (minutes)</label>
                    <input type="number" id="duree" name="duree" min="1"
                           value="{{ old('duree', $prestation->duree) }}">
                    @error('duree') <div class="erreur">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image</label>

                @if($prestation->image)
                    <div>
                        <img src="{{ asset('storage/' . $prestation->image) }}"
                             class="image-actuelle"
                             alt="{{ $prestation->nom }}">
                    </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*">
                <small style="color:#725d6d;">Laissez vide pour garder l'image actuelle.</small>
                @error('image') <div class="erreur">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="statut" value="1"
                           {{ old('statut', $prestation->statut) ? 'checked' : '' }}>
                    Prestation active
                </label>
            </div>

            <button type="submit" class="btn-enregistrer">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <a href="{{ route('prestations.index') }}" class="btn-annuler">Annuler</a>

        </form>
    </div>
</div>

@endsection