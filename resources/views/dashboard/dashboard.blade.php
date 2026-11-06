<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tableau de bord - All in One by Eva</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f8f1f5;
            color: #321b25;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 230px;
            background: #780d25;
            color: white;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .logo {
            text-align: center;
            padding: 8px 0 30px;
        }

        .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .logo h2 {
            font-family: Georgia, serif;
            font-style: italic;
            font-size: 22px;
        }

        .logo p {
            font-family: Georgia, serif;
            font-style: italic;
            font-size: 14px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 10px;
            margin-bottom: 4px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            border-radius: 9px;
            transition: .3s;
        }

        .menu a:hover,
        .menu a.active {
            background: #b94e72;
        }

        .menu a i {
            width: 17px;
            font-size: 15px;
        }

        .logout {
            margin-top: auto;
            border-top: 1px solid #a94c66;
            padding-top: 15px;
        }

        .logout button {
            width: 100%;
            border: none;
            background: transparent;
            color: white;
            text-align: left;
            padding: 12px 10px;
            cursor: pointer;
            font-size: 13px;
        }

        /* CONTENU PRINCIPAL */

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 60px;
            background: #fffafd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            border-bottom: 1px solid #f0dfe7;
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .menu-btn {
            border: none;
            background: transparent;
            font-size: 20px;
            cursor: pointer;
            color: #780d25;
        }

        .search {
            width: 300px;
            padding: 10px 15px;
            border: none;
            outline: none;
            border-radius: 20px;
            background: #f5edf1;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 13px;
        }

        .profile i {
            color: #780d25;
            font-size: 19px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e8b5c6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #780d25;
        }

        /* PAGE */

        .content {
            padding: 25px;
        }

        .welcome {
            margin-bottom: 20px;
        }

        .welcome h1 {
            font-size: 23px;
            color: #321b25;
        }

        .welcome h1 i {
            color: #780d25;
            margin-right: 8px;
        }

        .welcome p {
            margin: 5px 0 0 34px;
            color: #806d76;
            font-size: 13px;
        }

        /* STATISTIQUES */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            padding: 20px 15px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            gap: 15px;
            min-height: 90px;
        }

        .stat-card:nth-child(1) {
            background: #f5b8cd;
        }

        .stat-card:nth-child(2) {
            background: #893653;
            color: white;
        }

        .stat-card:nth-child(3) {
            background: #f5bfd0;
        }

        .stat-card:nth-child(4) {
            background: #dfb3d7;
        }

        .stat-card .icon {
            font-size: 27px;
            color: #a51c50;
        }

        .stat-card:nth-child(2) .icon {
            color: white;
        }

        .stat-card p {
            font-size: 12px;
            margin-bottom: 7px;
        }

        .stat-card h2 {
            font-size: 19px;
        }

        .stat-card small {
            display: block;
            text-align: right;
            font-size: 10px;
            margin-top: 5px;
        }

        /* GRAPHIQUES */

        .charts {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .chart-card {
            background: white;
            border-radius: 13px;
            padding: 18px;
            box-shadow: 0 3px 10px #e8d7df;
            min-width: 0;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .chart-header h3 {
            font-size: 15px;
        }

        .chart-header select {
            padding: 6px;
            border: 1px solid #eee;
            border-radius: 6px;
            font-size: 11px;
        }

        .chart-svg {
            width: 100%;
            height: 175px;
        }

        /* CAMEMBERT */

        .distribution {
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 15px;
            min-height: 175px;
        }

        .donut {
            width: 135px;
            height: 135px;
            border-radius: 50%;
            background: conic-gradient(
                #a51c50 0% 40%,
                #e77c91 40% 70%,
                #f0a0b2 70% 90%,
                #f7c3d0 90% 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .donut::before {
            content: "100%";
            width: 85px;
            height: 85px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
        }

        .legend {
            list-style: none;
            font-size: 12px;
        }

        .legend li {
            margin: 12px 0;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            margin-right: 7px;
        }

        /* INFORMATIONS DU BAS */

        .bottom {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .bottom-card {
            background: white;
            border-radius: 13px;
            padding: 17px;
            box-shadow: 0 3px 10px #e8d7df;
            min-width: 0;
        }

        .bottom-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 5px;
        }

        .bottom-title h3 {
            font-size: 13px;
        }

        .bottom-title i {
            color: #780d25;
            margin-right: 5px;
        }

        .bottom-title a {
            color: #321b25;
            font-size: 10px;
        }

        .item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            margin-top: 12px;
        }

        .item-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f3d3df;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #780d25;
        }

        .item p {
            line-height: 1.7;
        }

        .tag {
            background: #f8d5e2;
            color: #a51c50;
            border-radius: 12px;
            padding: 4px 7px;
            font-size: 10px;
        }

        /* RESPONSIVE */

        @media (max-width: 1000px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .bottom {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 750px) {
            .sidebar {
                width: 65px;
                padding: 15px 5px;
            }

            .logo h2,
            .logo p,
            .menu a span,
            .logout span {
                display: none;
            }

            .logo i {
                font-size: 25px;
            }

            .menu a {
                justify-content: center;
            }

            .charts {
                grid-template-columns: 1fr;
            }

            .search {
                width: 170px;
            }

            .content {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .search {
                width: 130px;
            }

            .profile {
                gap: 7px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- BARRE LATERALE -->
    <aside class="sidebar">

        <div class="logo">
            <i class="fa-solid fa-spa"></i>
            <h2>All in One</h2>
            <p>by Eva</p>
        </div>

        <nav class="menu">

            <a href="{{ route('dashboard') }}" class="active">
                <i class="fa-solid fa-house"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-users"></i>
                <span>Clients</span>
            </a>

            <a href="#">
                <i class="fa-regular fa-calendar-days"></i>
                <span>Rendez-vous</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-hand-sparkles"></i>
                <span>Prestations</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-money-bill-wave"></i>
                <span>Paiements</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-wallet"></i>
                <span>Dépenses</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-box"></i>
                <span>Produits & Stock</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-user-tie"></i>
                <span>Employés</span>
            </a>

            <a href="#">
                <i class="fa-brands fa-whatsapp"></i>
                <span>Messages WhatsApp</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Promotions</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-chart-column"></i>
                <span>Rapports</span>
            </a>

            <a href="#">
                <i class="fa-solid fa-gear"></i>
                <span>Paramètres</span>
            </a>

        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>

    </aside>


    <!-- CONTENU PRINCIPAL -->
    <main class="main">

        <!-- BARRE DU HAUT -->
        <header class="topbar">

            <div class="top-left">
                <button class="menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <input type="search"
                    class="search"
                    placeholder="⌕  Rechercher un client, un rendez-vous...">
            </div>

            <div class="profile">
                <i class="fa-solid fa-bell"></i>

                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <strong>
                    {{ Auth::user()->name ?? 'Administratrice' }}
                </strong>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

        </header>


        <!-- TABLEAU DE BORD -->
        <section class="content">

            <div class="welcome">
                <h1>
                    <i class="fa-solid fa-house"></i>
                    Tableau de bord
                </h1>
                <p>Bienvenue dans votre espace de gestion !</p>
            </div>


            <!-- CARTES STATISTIQUES -->
            <div class="stats">

                <div class="stat-card">
                    <div class="icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p>Total Clients</p>
                        <h2>1 250</h2>
                        <small>↑ +12%</small>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                    <div>
                        <p>Rendez-vous du jour</p>
                        <h2>24</h2>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                    </div>
                    <div>
                        <p>CA du jour</p>
                        <h2>450 000 <small>FCFA</small></h2>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p>Dépenses du mois</p>
                        <h2>180 000 <small>FCFA</small></h2>
                    </div>
                </div>

            </div>


            <!-- GRAPHIQUES -->
            <div class="charts">

                <!-- EVOLUTION DU CHIFFRE D'AFFAIRES -->
                <div class="chart-card">

                    <div class="chart-header">
                        <h3>Évolution du chiffre d'affaires</h3>

                        <select>
                            <option>6 derniers mois</option>
                            <option>Cette année</option>
                        </select>
                    </div>

                    <svg class="chart-svg" viewBox="0 0 450 190"
                        preserveAspectRatio="none">

                        <defs>
                            <linearGradient id="area" x1="0" y1="0"
                                x2="0" y2="1">
                                <stop offset="0%" stop-color="#b52e60"
                                    stop-opacity=".35"/>
                                <stop offset="100%" stop-color="#b52e60"
                                    stop-opacity="0"/>
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

                        <path d="M55 130
                            Q100 105 130 92
                            T220 102
                            T310 82
                            T420 62
                            L420 155 L55 155 Z"
                            fill="url(#area)"/>

                        <path d="M55 130
                            Q100 105 130 92
                            T220 102
                            T310 82
                            T420 62"
                            fill="none"
                            stroke="#a51c50"
                            stroke-width="2.5"/>

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


                <!-- REPARTITION DES PRESTATIONS -->
                <div class="chart-card">

                    <div class="chart-header">
                        <h3>Répartition des prestations</h3>
                    </div>

                    <div class="distribution">

                        <div class="donut"></div>

                        <ul class="legend">

                            <li>
                                <span><i class="dot" style="background:#a51c50"></i>Coiffure</span>
                                <strong>40%</strong>
                            </li>

                            <li>
                                <span><i class="dot" style="background:#e77c91"></i>Soins visage</span>
                                <strong>30%</strong>
                            </li>

                            <li>
                                <span><i class="dot" style="background:#f0a0b2"></i>Manucure</span>
                                <strong>20%</strong>
                            </li>

                            <li>
                                <span><i class="dot" style="background:#f7c3d0"></i>Massages</span>
                                <strong>10%</strong>
                            </li>

                        </ul>

                    </div>
                </div>

            </div>


            <!-- INFORMATIONS DU BAS -->
            <div class="bottom">

                <!-- RENDEZ-VOUS -->
                <div class="bottom-card">

                    <div class="bottom-title">
                        <h3>
                            <i class="fa-regular fa-calendar-days"></i>
                            Rendez-vous à venir
                        </h3>
                        <a href="#">Voir tout →</a>
                    </div>

                    <div class="item">
                        <div class="item-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <p>
                            <strong>15:00 - Coiffure</strong><br>
                            Avec Awa Diop
                        </p>

                        <span class="tag">Aujourd'hui</span>
                    </div>

                </div>


                <!-- ANNIVERSAIRES -->
                <div class="bottom-card">

                    <div class="bottom-title">
                        <h3>
                            <i class="fa-solid fa-gift"></i>
                            Anniversaires à venir
                        </h3>
                        <a href="#">Voir tout →</a>
                    </div>

                    <div class="item">
                        <div class="item-icon">
                            <i class="fa-solid fa-cake-candles"></i>
                        </div>

                        <p>
                            <strong>28 Oct.</strong>
                            Aminata Cissé
                        </p>
                    </div>

                </div>


                <!-- ALERTES STOCK -->
                <div class="bottom-card">

                    <div class="bottom-title">
                        <h3>
                            <i class="fa-solid fa-triangle-exclamation"
                                style="color:#d88b43"></i>
                            Alertes de stock
                        </h3>
                        <a href="#">Voir tout →</a>
                    </div>

                    <div class="item">
                        <div class="item-icon">
                            <i class="fa-solid fa-bottle-water"></i>
                        </div>

                        <p>
                            <strong>Shampoing</strong><br>
                            <span class="tag">Stock faible</span>
                        </p>
                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>