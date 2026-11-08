<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All in One by Eva</title>

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

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR (identique au tableau de bord) */

        .sidebar {
            width: 230px;
            background: #780d25;
            color: white;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar .logo {
            text-align: center;
            padding: 8px 0 30px;
        }

        .sidebar .logo i {
            font-size: 35px;
            margin-bottom: 8px;
        }

        .sidebar .logo h2 {
            font-family: Georgia, serif;
            font-style: italic;
            font-size: 22px;
            font-weight: bold;
        }

        .sidebar .logo p {
            font-family: Georgia, serif;
            font-style: italic;
            font-size: 14px;
        }

        .sidebar .menu a {
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

        .sidebar .menu a:hover,
        .sidebar .menu a.active {
            background: #b94e72;
        }

        .sidebar .menu a i {
            width: 17px;
            font-size: 15px;
            text-align: center;
        }

        .sidebar .logout {
            margin-top: auto;
            border-top: 1px solid #a94c66;
            padding-top: 15px;
        }

        .sidebar .logout button {
            width: 100%;
            border: none;
            background: transparent;
            color: white;
            text-align: left;
            padding: 12px 10px;
            cursor: pointer;
            font-size: 13px;
            font-family: inherit;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        @media (max-width: 750px) {
            .sidebar {
                width: 65px;
                padding: 15px 5px;
            }

            .sidebar .logo h2,
            .sidebar .logo p,
            .sidebar .menu a span,
            .sidebar .logout span {
                display: none;
            }

            .sidebar .logo i {
                font-size: 25px;
            }

            .sidebar .menu a {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<div class="app-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <i class="fa-solid fa-spa"></i>
            <h2>All in One</h2>
            <p>by Eva</p>
        </div>

        <nav class="menu">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
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

            <a href="{{ route('prestations.index') }}"
               class="{{ request()->routeIs('prestations.*') ? 'active' : '' }}">
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
    <main class="main-content">
        @yield('contenu')
    </main>

</div>

</body>
</html>