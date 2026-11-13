@extends('layouts.app')

@section('search_action', route('prestations.index'))
@section('search_placeholder', 'Rechercher une prestation...')

@section('contenu')

<style>
    .prestations-page {
        background: #fff7fa;
        padding: 25px 28px;
        color: #390c29;
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

    /* Plus d'espace sur les 3 dernières colonnes (Durée, Statut, Actions) */
.prestations-table th:nth-last-child(-n+3),
.prestations-table td:nth-last-child(-n+3) {
    padding-left: 35px;
    padding-right: 35px;
}

/* Colonne Actions collée à droite */
.prestations-table th:last-child {
    text-align: right;
}

.actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 14px;
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
        gap: 15px;
        flex-wrap: wrap;
    }

    .pages {
        display: flex;
        gap: 6px;
    }

    .pages a,
    .pages span {
        border: 1px solid #f0dce6;
        background: white;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        color: #780d35;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 600;
    }

    .pages a:hover {
        background: #fbe2ed;
    }

    .pages .current {
        background: #780d35;
        color: white;
    }

    .pages .disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    @media (max-width: 1000px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
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
    }
</style>

<div class="prestations-page">

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
                <h2>{{ $total }}</h2>
                <p>Prestations totales</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>

            <div>
                <h2 style="font-size:25px">{{ number_format($prixMoyen, 0, ',', ' ') }} <small>FCFA</small></h2>
                <p>Prix moyen</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div>
                <h2>{{ $actives }}</h2>
                <p>Prestations actives</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-pause"></i>
            </div>

            <div>
                <h2>{{ $inactives }}</h2>
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

            <tbody>

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
                            <div class="actions">

                                <a href="{{ route('prestations.edit', $prestation->id) }}"
                                   class="action-btn"
                                   style="text-decoration:none; display:inline-flex;"
                                   title="Modifier">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('prestations.destroy', $prestation->id) }}"
                                      method="POST"
                                      style="margin:0;"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette prestation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="margin-right:0;" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
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
        <strong>
            Affichage de {{ $prestations->firstItem() ?? 0 }}
            à {{ $prestations->lastItem() ?? 0 }}
            sur {{ $prestations->total() }} prestations
        </strong>

        @if ($prestations->hasPages())
            <div class="pages">

                {{-- Précédent --}}
                @if ($prestations->onFirstPage())
                    <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                @else
                    <a href="{{ $prestations->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                @endif

                {{-- Numéros de pages (2 avant et 2 après la page courante) --}}
                @for ($i = max(1, $prestations->currentPage() - 2); $i <= min($prestations->lastPage(), $prestations->currentPage() + 2); $i++)
                    @if ($i == $prestations->currentPage())
                        <span class="current">{{ $i }}</span>
                    @else
                        <a href="{{ $prestations->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Suivant --}}
                @if ($prestations->hasMorePages())
                    <a href="{{ $prestations->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                @else
                    <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                @endif

            </div>
        @endif
    </div>

</div>

@endsection