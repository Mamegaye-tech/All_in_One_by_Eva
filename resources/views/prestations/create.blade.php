@extends('layouts.app')

@section('contenu')

<style>
    .form-page { background:#fff7fa; min-height:100vh; padding:25px 28px; color:#390c29; }
    .form-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; gap:15px; flex-wrap:wrap; }
    .form-header h1 { font-size:30px; color:#780d25; }
    .form-header p { color:#806d76; margin-top:6px; }
    .btn-retour { background:#fff; color:#780d25; padding:12px 20px; border-radius:12px; text-decoration:none; font-weight:600; box-shadow:0 2px 8px #ecd9e2; }

    .form-card { background:#fff; border:1px solid #f0dce6; border-radius:18px; padding:30px; max-width:860px; margin:0 auto; box-shadow:0 3px 10px #f0dce6; }
    .grille { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .pleine { grid-column:1 / -1; }

    .champ label { display:block; font-weight:600; font-size:14px; margin-bottom:8px; }
    .champ input[type=text],
    .champ input[type=number],
    .champ input[type=file],
    .champ select,
    .champ textarea {
        width:100%; padding:12px 14px; border:1px solid #ecd9e2; border-radius:12px;
        background:#fffafd; font-size:14px; font-family:inherit; outline:none;
    }
    .champ input:focus, .champ select:focus, .champ textarea:focus { border-color:#780d25; }
    .champ textarea { min-height:110px; resize:vertical; }
    .erreur { color:#c0392b; font-size:12px; margin-top:5px; }

    .apercu { width:170px; height:110px; object-fit:cover; border-radius:12px; margin-bottom:10px; display:none; }
    .check { display:flex; align-items:center; gap:10px; font-weight:600; }
    .check input { width:18px; height:18px; accent-color:#780d25; }

    .boutons { display:flex; justify-content:flex-end; gap:12px; margin-top:28px; }
    .btn-annuler { background:#f7dce9; color:#780d25; padding:13px 24px; border-radius:12px; text-decoration:none; font-weight:600; }
    .btn-enregistrer { background:#780d25; color:#fff; border:none; padding:13px 26px; border-radius:12px; font-weight:600; cursor:pointer; font-size:14px; }
    .btn-enregistrer:hover { background:#a51b56; }

    @media (max-width:700px) {
        .grille { grid-template-columns:1fr; }
        .form-page { padding:15px; }
    }
</style>

<div class="form-page">

    <div class="form-header">
        <div>
            <h1><i class="fas fa-star"></i> Ajouter une prestation</h1>
            <p>Remplissez les informations de votre nouvelle prestation.</p>
        </div>
        <a href="{{ route('prestations.index') }}" class="btn-retour">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('prestations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grille">

                <div class="champ">
                    <label for="nom">Nom de la prestation *</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" placeholder="Ex : Soin visage éclat">
                    @error('nom') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ">
                    <label for="categorie">Catégorie *</label>
                    <select id="categorie" name="categorie">
                        <option value="">Choisir une catégorie</option>
                        @foreach (['Soin visage', 'Massage', 'Onglerie', 'Coiffure', 'Maquillage', 'Autre'] as $cat)
                            <option value="{{ $cat }}" {{ old('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('categorie') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ">
                    <label for="prix">Prix (FCFA) *</label>
                    <input type="number" id="prix" name="prix" min="0" value="{{ old('prix') }}" placeholder="Ex : 25000">
                    @error('prix') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ">
                    <label for="duree">Durée (minutes) *</label>
                    <input type="number" id="duree" name="duree" min="1" value="{{ old('duree') }}" placeholder="Ex : 60">
                    @error('duree') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ pleine">
                    <label for="image">Image de la prestation</label>
                    <img id="apercu" class="apercu" alt="Aperçu">
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ pleine">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Décrivez la prestation...">{{ old('description') }}</textarea>
                    @error('description') <div class="erreur">{{ $message }}</div> @enderror
                </div>

                <div class="champ pleine">
                    <label class="check">
                        <input type="checkbox" name="statut" value="1" checked>
                        Prestation active
                    </label>
                </div>

            </div>

            <div class="boutons">
                <a href="{{ route('prestations.index') }}" class="btn-annuler">Annuler</a>
                <button type="submit" class="btn-enregistrer">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const fichier = e.target.files[0];
        const apercu = document.getElementById('apercu');
        if (fichier) {
            apercu.src = URL.createObjectURL(fichier);
            apercu.style.display = 'block';
        }
    });
</script>

@endsection