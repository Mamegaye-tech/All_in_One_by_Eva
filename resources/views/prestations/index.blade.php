@extends('layouts.app')

@section('contenu')

<style>
    .prestations-page {
        background: #fff7fa;
        min-height: 100vh;
        padding: 25px 28px;
        color: #390c29;
    }

    .topbar {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 30px;
    }

    .menu-btn {
        color: #780d35;
        font-size: 25px;
        border: none;
        background: none;
    }

    .search-box {
        background: #f9eaf1;
        border-radius: 30px;
        padding: 13px 22px;
        width: 45%;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-box input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
    }

    .admin {
        margin-left: auto;
        font-weight: 600;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: bold;
        color: #780d35;
    }

    .page-header p {
        color: #563b4c;
        margin-top: 5px;
    }

    .btn-ajouter {
        background: #780d35;
        color: white;
        padding: 14px 22px;
        border-radius: 13px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-ajouter:hover {
        background: #a51b56;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #f9dce9;
        padding: 20px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #f5c2d9;
        color: #b51c60;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 27px;
    }

    .stat-card h2 {
        font-size: 28px;
        font-weight: bold;
    }

    .stat-card p {
        font-size: 15px;
    }

    .table-container {
        background: white;
        border-radius: 18px;
        overflow-x: auto;
        border: 1px solid #f0dce6;
    }

    .prestations-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .prestations-table thead {
        background: #f7dce9;
    }

    .prestations-table th {
        padding: 19px 15px;
        text-align: left;
        font-weight: 700;
    }

    .prestations-table td {
        padding: 10px 15px;
        border-bottom: 1px solid #f1dfe8;
    }

    .prestations-table tbody tr:hover {
        background: #fff8fb;
    }

    .prestation-img {
        width: 132px;
        height: 68px;
        object-fit: cover;
        border-radius: 12px;
    }

    .prestation-name {
        font-weight: bold;
        font-size: 17px;
    }

    .prestation-description {
        color: #725d6d;
        font-size: 14px;
        margin-top: 3px;
    }

    .categorie {
        display: inline-block;
        background: #f7d5e8;
        color: #a01450;
        padding: 9px 17px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
    }

    .statut {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
    }

    .actif {
        background: #dcf7e6;
        color: #16894d;
    }

    .inactif {
        background: #ffebd1;
        color: #bd681a;
    }

    .action-btn {
        border: none;
        background: #fbe2ed;
        color: #950e45;
        padding: 12px;
        border-radius: 12px;
        cursor: pointer;
        margin-right: 5px;
        font-size: 17px;
    }

    .action-btn:hover {
        background: #f4bfd6;
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 10px;
    }

    .pages button {
        border: 1px solid #f0dce6;
        background: white;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        color: #780d35;
        cursor: pointer;
    }

    .pages .current {
        background: #780d35;
        color: white;
    }

    @media(max-width: 1000px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 600px) {
        .prestations-page {
            padding: 15px;
        }

        .stats {
            grid-template-columns: 1fr;
        }

        .page-header {
            align-items: flex-start;
            gap: 15px;
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }
    }

    /* Correction de la barre latérale sur Prestations */
body > div > aside {
    width: 256px !important;
    min-width: 256px !important;
    display: flex !important;
    flex-direction: column !important;
}

body > div > aside nav {
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 8px !important;
}

body > div > aside nav a {
    display: flex !important;
    align-items: center !important;
    width: 100% !important;
}
</style>



<div class="prestations-page">

    <!-- BARRE SUPERIEURE -->
    <div class="topbar">

        <button class="menu-btn">
            <i class="fas fa-bars"></i>
        </button>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchPrestation"
                placeholder="Rechercher une prestation...">
        </div>

        <div class="admin">
            <i class="fas fa-bell" style="color:#780d35;font-size:22px"></i>
            &nbsp;&nbsp;
            <i class="fas fa-user-circle" style="font-size:30px"></i>
            Administratrice
            <i class="fas fa-chevron-down"></i>
        </div>

    </div>

    <!-- TITRE -->
    <div class="page-header">

        <div>
            <h1>
                <i class="fas fa-star"></i>
                Prestations
            </h1>

            <p>Gérez vos prestations et leurs informations.</p>
        </div>

       <a href="{{ route('prestations.create') }}" class="btn-ajouter" style="text-decoration:none;">
    <i class="fas fa-plus"></i>
    &nbsp; Ajouter une prestation
</a>

    </div>
    @if (session('success'))
    <div style="background:#dcf7e6;color:#16894d;padding:13px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;">
        {{ session('success') }}
    </div>
@endif

    <!-- STATISTIQUES -->
    <div class="stats">

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-crown"></i>
            </div>

            <div>
                <h2 id="totalPrestations">6</h2>
                <p>Prestations totales</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>

            <div>
                <h2 style="font-size:25px">450 000 <small>FCFA</small></h2>
                <p>Revenus générés</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div>
                <h2 id="totalActives">4</h2>
                <p>Prestations actives</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-pause"></i>
            </div>

            <div>
                <h2 id="totalInactives">2</h2>
                <p>Prestations inactives</p>
            </div>
        </div>

    </div>

    <!-- TABLEAU DES PRESTATIONS -->
    <div class="table-container">

        <table class="prestations-table">

            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom de la prestation</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="listePrestations">

    @forelse($prestations as $prestation)

        <tr>
            <td>
                @if($prestation->image)
                    <img src="{{ asset('storage/' . $prestation->image) }}"
                         class="prestation-img"
                         alt="{{ $prestation->nom }}">
                @else
                    Aucune image
                @endif
            </td>

            <td>
                <div class="prestation-name">
                    {{ $prestation->nom }}
                </div>

                <div class="prestation-description">
                    {{ $prestation->description }}
                </div>
            </td>

            <td>
                <span class="categorie">
                    {{ $prestation->categorie }}
                </span>
            </td>

            <td>
                {{ number_format($prestation->prix, 0, ',', ' ') }} FCFA
            </td>

            <td>{{ $prestation->duree }} min</td>

            <td>
                @if($prestation->statut)
                    <span class="statut actif">● Actif</span>
                @else
                    <span class="statut inactif">● Inactif</span>
                @endif
            </td>

            <td>
                <button class="action-btn">
                    <i class="fas fa-pen"></i>
                </button>

                <button class="action-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="7" style="text-align:center;padding:30px;">
                Aucune prestation enregistrée.
            </td>
        </tr>

    @endforelse

</tbody>
        </table>

    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <strong id="affichage">Affichage de 1 à 6 sur 6 prestations</strong>

        <div class="pages">
            <button><i class="fas fa-chevron-left"></i></button>
            <button class="current">1</button>
            <button><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

</div>

<script>
    // RECHERCHER UNE PRESTATION
    document.getElementById('searchPrestation').addEventListener('input', function () {
        let recherche = this.value.toLowerCase();
        let lignes = document.querySelectorAll('#listePrestations tr');

        lignes.forEach(function (ligne) {
            let contenu = ligne.textContent.toLowerCase();
            ligne.style.display = contenu.includes(recherche) ? '' : 'none';
        });
    });

    // SUPPRIMER UNE PRESTATION
    function supprimerPrestation(bouton) {
        if (confirm('Voulez-vous vraiment supprimer cette prestation ?')) {
            bouton.closest('tr').remove();
            actualiserStatistiques();
        }
    }

    // MODIFIER UNE PRESTATION
    function modifierPrestation(bouton) {
        let ligne = bouton.closest('tr');
        let nom = ligne.querySelector('.prestation-name').textContent;

        alert('Modification de la prestation : ' + nom);
    }

    // AJOUTER UNE PRESTATION
    function ajouterPrestation() {
        alert('La fenêtre d’ajout de prestation sera créée dans la prochaine étape.');
    }

    // ACTUALISER LES STATISTIQUES
    function actualiserStatistiques() {
        let lignes = [...document.querySelectorAll('#listePrestations tr')];

        let actives = lignes.filter(ligne =>
            ligne.querySelector('.statut')?.classList.contains('actif')
        ).length;

        let inactives = lignes.length - actives;

        document.getElementById('totalPrestations').textContent = lignes.length;
        document.getElementById('totalActives').textContent = actives;
        document.getElementById('totalInactives').textContent = inactives;

        document.getElementById('affichage').textContent =
            `Affichage de 1 à ${lignes.length} sur ${lignes.length} prestations`;
    }
</script>

@endsection