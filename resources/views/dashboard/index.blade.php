@extends('layouts.app')

@push('styles')
<style>
    .dash { color: #321b25; font-family: Arial, sans-serif; }

    /* Barre du haut */
    .dash .topbar { height: 60px; background: #fffafd; display: flex; align-items: center; justify-content: space-between; padding: 0 25px; border: 1px solid #f0dfe7; border-radius: 13px; margin-bottom: 20px; }
    .dash .top-left { display: flex; align-items: center; gap: 25px; }
    .dash .search { width: 300px; padding: 10px 15px; border: none; outline: none; border-radius: 20px; background: #f5edf1; }
    .dash .profile { display: flex; align-items: center; gap: 15px; font-size: 13px; }
    .dash .profile i { color: #780d25; font-size: 19px; }
    .dash .avatar { width: 32px; height: 32px; border-radius: 50%; background: #e8b5c6; display: flex; align-items: center; justify-content: center; color: #780d25; }

    /* Titre */
    .dash .welcome { margin-bottom: 20px; }
    .dash .welcome h1 { font-size: 23px; }
    .dash .welcome h1 i { color: #780d25; margin-right: 8px; }
    .dash .welcome p { margin: 5px 0 0 34px; color: #806d76; font-size: 13px; }

    /* Statistiques */
    .dash .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
    .dash .stat-card { padding: 20px 15px; border-radius: 13px; display: flex; align-items: center; gap: 15px; min-height: 90px; }
    .dash .stat-card:nth-child(1) { background: #f5b8cd; }
    .dash .stat-card:nth-child(2) { background: #893653; color: white; }
    .dash .stat-card:nth-child(3) { background: #f5bfd0; }
    .dash .stat-card:nth-child(4) { background: #dfb3d7; }
    .dash .stat-card .icon { font-size: 27px; color: #a51c50; }
    .dash .stat-card:nth-child(2) .icon { color: white; }
    .dash .stat-card p { font-size: 12px; margin-bottom: 7px; }
    .dash .stat-card h2 { font-size: 19px; }
    .dash .stat-card small { font-size: 10px; }

    /* Graphiques */
    .dash .charts { display: grid; grid-template-columns: 1.2fr 1fr; gap: 15px; margin-bottom: 20px; }
    .dash .chart-card, .dash .bottom-card { background: white; border-radius: 13px; padding: 18px; box-shadow: 0 3px 10px #e8d7df; min-width: 0; }
    .dash .chart-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; }
    .dash .chart-header h3 { font-size: 15px; }
    .dash .chart-header select { padding: 6px; border: 1px solid #eee; border-radius: 6px; font-size: 11px; }
    .dash .chart-svg { width: 100%; height: 175px; }

    .dash .distribution { display: flex; align-items: center; justify-content: space-around; gap: 15px; min-height: 175px; }
    .dash .donut { width: 135px; height: 135px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
        background: conic-gradient(#a51c50 0% 40%, #e77c91 40% 70%, #f0a0b2 70% 90%, #f7c3d0 90% 100%); }
    .dash .donut::before { content: "100%"; width: 85px; height: 85px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold; }
    .dash .legend { list-style: none; font-size: 12px; }
    .dash .legend li { margin: 12px 0; display: flex; justify-content: space-between; gap: 20px; }
    .dash .dot { display: inline-block; width: 9px; height: 9px; border-radius: 50%; margin-right: 7px; }

    /* Bas de page */
    .dash .bottom { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
    .dash .bottom-title { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 5px; }
    .dash .bottom-title h3 { font-size: 13px; }
    .dash .bottom-title i { color: #780d25; margin-right: 5px; }
    .dash .bottom-title a { font-size: 10px; }
    .dash .item { display: flex; align-items: center; gap: 10px; font-size: 11px; margin-top: 12px; }
    .dash .item-icon { width: 32px; height: 32px; border-radius: 50%; background: #f3d3df; display: flex; align-items: center; justify-content: center; color: #780d25; }
    .dash .item p { line-height: 1.7; }
    .dash .tag { background: #f8d5e2; color: #a51c50; border-radius: 12px; padding: 4px 7px; font-size: 10px; }

    @media (max-width: 1000px) {
        .dash .stats { grid-template-columns: repeat(2, 1fr); }
        .dash .bottom { grid-template-columns: 1fr; }
    }
    @media (max-width: 750px) {
        .dash .charts { grid-template-columns: 1fr; }
        .dash .search { width: 170px; }
    }
    @media (max-width: 480px) {
        .dash .stats { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dash">

    <!-- BARRE DU HAUT -->
    <header class="topbar">
        <div class="top-left">
            <input type="search" class="search" placeholder="Rechercher un client, un rendez-vous...">
        </div>
        <div class="profile">
            <i class="fa-solid fa-bell"></i>
            <div class="avatar"><i class="fa-solid fa-user"></i></div>
            <strong>{{ auth()->user()->name }}</strong>
        </div>
    </header>

    <!-- TITRE -->
    <div class="welcome">
        <h1><i class="fa-solid fa-house"></i> Tableau de bord</h1>
        <p>Bienvenue dans votre espace de gestion !</p>
    </div>

    <!-- STATISTIQUES -->
    <div class="stats">
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-users"></i></div>
            <div><p>Total Clients</p><h2>1 250</h2><small>↑ +12%</small></div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-regular fa-calendar-days"></i></div>
            <div><p>Rendez-vous du jour</p><h2>24</h2></div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
            <div><p>CA du jour</p><h2>450 000 <small>FCFA</small></h2></div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-wallet"></i></div>
            <div><p>Dépenses du mois</p><h2>180 000 <small>FCFA</small></h2></div>
        </div>
    </div>

    <!-- GRAPHIQUES -->
    <div class="charts">

        <div class="chart-card">
            <div class="chart-header">
                <h3>Évolution du chiffre d'affaires</h3>
                <select>
                    <option>6 derniers mois</option>
                    <option>Cette année</option>
                </select>
            </div>

            <svg class="chart-svg" viewBox="0 0 450 190" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="area" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#b52e60" stop-opacity=".35"/>
                        <stop offset="100%" stop-color="#b52e60" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <g stroke="#eee" stroke-width="1">
                    <line x1="55" y1="20" x2="435" y2="20"/>
                    <line x1="55" y1="65" x2="435" y2="65"/>
                    <line x1="55" y1="110" x2="435" y2="110"/>
                    <line x1="55" y1="155" x2="435" y2="155"/>
                </g>
                <g fill="#555" font-size="11">
                    <text x="5" y="24">750k</text>
                    <text x="5" y="69">500k</text>
                    <text x="5" y="114">250k</text>
                    <text x="25" y="159">0</text>
                </g>
                <path d="M55 130 Q100 105 130 92 T220 102 T310 82 T420 62 L420 155 L55 155 Z" fill="url(#area)"/>
                <path d="M55 130 Q100 105 130 92 T220 102 T310 82 T420 62" fill="none" stroke="#a51c50" stroke-width="2.5"/>
                <g fill="#780d25">
                    <circle cx="55" cy="130" r="4"/>
                    <circle cx="130" cy="92" r="4"/>
                    <circle cx="220" cy="102" r="4"/>
                    <circle cx="310" cy="82" r="4"/>
                    <circle cx="420" cy="62" r="4"/>
                </g>
                <g fill="#555" font-size="11">
                    <text x="48" y="175">Jan</text>
                    <text x="122" y="175">Fév</text>
                    <text x="212" y="175">Avr</text>
                    <text x="302" y="175">Mai</text>
                    <text x="410" y="175">Juin</text>
                </g>
            </svg>
        </div>

        <div class="chart-card">
            <div class="chart-header"><h3>Répartition des prestations</h3></div>
            <div class="distribution">
                <div class="donut"></div>
                <ul class="legend">
                    <li><span><i class="dot" style="background:#a51c50"></i>Coiffure</span><strong>40%</strong></li>
                    <li><span><i class="dot" style="background:#e77c91"></i>Soins visage</span><strong>30%</strong></li>
                    <li><span><i class="dot" style="background:#f0a0b2"></i>Manucure</span><strong>20%</strong></li>
                    <li><span><i class="dot" style="background:#f7c3d0"></i>Massages</span><strong>10%</strong></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- BAS DE PAGE -->
    <div class="bottom">

        <div class="bottom-card">
            <div class="bottom-title">
                <h3><i class="fa-regular fa-calendar-days"></i> Rendez-vous à venir</h3>
                <a href="#">Voir tout →</a>
            </div>
            <div class="item">
                <div class="item-icon"><i class="fa-solid fa-user"></i></div>
                <p><strong>15:00 - Coiffure</strong><br>Avec Awa Diop</p>
                <span class="tag">Aujourd'hui</span>
            </div>
        </div>

        <div class="bottom-card">
            <div class="bottom-title">
                <h3><i class="fa-solid fa-gift"></i> Anniversaires à venir</h3>
                <a href="#">Voir tout →</a>
            </div>
            <div class="item">
                <div class="item-icon"><i class="fa-solid fa-cake-candles"></i></div>
                <p><strong>28 Oct.</strong> Aminata Cissé</p>
            </div>
        </div>

        <div class="bottom-card">
            <div class="bottom-title">
                <h3><i class="fa-solid fa-triangle-exclamation" style="color:#d88b43"></i> Alertes de stock</h3>
                <a href="#">Voir tout →</a>
            </div>
            <div class="item">
                <div class="item-icon"><i class="fa-solid fa-bottle-water"></i></div>
                <p><strong>Shampoing</strong><br><span class="tag">Stock faible</span></p>
            </div>
        </div>

    </div>

</div>
@endsection