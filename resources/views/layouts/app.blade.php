<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'All in One by Eva')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
    <style>
    /* Masquer la barre de défilement de la sidebar */
    .sidebar-menu {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .sidebar-menu::-webkit-scrollbar {
        display: none;
    }

    /* Garder un défilement fluide */
    .sidebar-menu {
        scroll-behavior: smooth;
    }
</style>
</head>

<body class="bg-[#FFF8FA] text-[#321b25]">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar"
               class="w-64 h-screen sticky top-0 bg-[#700D29] text-white flex flex-col px-4 py-4
                      max-lg:fixed max-lg:inset-y-0 max-lg:left-0 max-lg:z-40 max-lg:shadow-2xl">

            <!-- LOGO -->
            <div class="text-center mb-5 border-b border-pink-300/40 pb-3">
                <img src="{{ asset('images/logo1.png') }}"
                     alt="All in One by Eva"
                     class="w-28 mx-auto h-auto">
            </div>

            <!-- MENU -->
            <nav class="flex-1 space-y-2 text-sm overflow-y-auto pt-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

                <x-nav-link route="dashboard" icon="fa-house">
                    Tableau de bord
                </x-nav-link>

                <x-nav-link route="clients.index" pattern="clients.*" icon="fa-users">
                    Clients
                </x-nav-link>

                <x-nav-link route="rendez-vous.index" pattern="rendez-vous.*" icon="fa-calendar-days">
                    Rendez-vous
                </x-nav-link>

                <x-nav-link route="prestations.index" pattern="prestations.*" icon="fa-spa">
                    Prestations
                </x-nav-link>

                <x-nav-link route="caisse.index" pattern="caisse.*" icon="fa-cash-register">
                Caisse
                </x-nav-link>

                <x-nav-link route="depenses.index" icon="fa-sack-dollar">
                    Dépenses
                </x-nav-link>

                <x-nav-link route="stock.index" icon="fa-boxes-stacked">
                    Stock
                </x-nav-link>

                <x-nav-link route="anniversaires.index" icon="fa-cake-candles">
                    Anniversaires
                </x-nav-link>

                <x-nav-link route="campagnes.index" icon="fa-gift">
                    Campagnes
                </x-nav-link>

                <x-nav-link route="rapports.index" icon="fa-chart-column">
                    Rapports
                </x-nav-link>

                <x-nav-link route="equipe.index" icon="fa-user-tie">
                    Equipe
                </x-nav-link>

                <x-nav-link route="parametres.index" icon="fa-gear">
                    Paramètres
                </x-nav-link>

            </nav>

            <!-- DECONNEXION -->
            <div class="border-t border-pink-300/40 pt-3 mt-3">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 text-left">

                        <i class="fas fa-right-from-bracket w-6 text-lg"></i>

                        <span>Déconnexion</span>

                    </button>
                </form>

            </div>

        </aside>

        <!-- CONTENU PRINCIPAL -->
        <div class="flex-1 min-w-0 flex flex-col">

            <!-- BARRE DU HAUT -->
            <header class="sticky top-0 z-30 flex items-center gap-4 border-b border-[#f0dfe7] bg-white/90 px-6 py-3 backdrop-blur">

                <button type="button" id="burger" aria-label="Menu"
                        class="flex h-10 w-10 items-center justify-center rounded-xl text-lg transition hover:bg-[#f5edf1]">
                    <i class="fa-solid fa-bars"></i>
                </button>

            @unless (View::hasSection('sans_recherche'))
                <form method="GET" action="@yield('search_action', route('clients.index'))" class="relative max-w-md flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm text-[#806d76]"></i>
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="@yield('search_placeholder', 'Rechercher un client...')"
                        class="w-full rounded-full bg-[#f5edf1] py-2.5 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-[#a51c50]/40">
                </form>
            @endunless

                <div class="ml-auto flex items-center gap-4">
                    <button type="button" aria-label="Notifications"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-lg text-[#780d25] transition hover:bg-[#f5edf1]">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-[#a51c50]"></span>
                    </button>

                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e8b5c6] font-bold text-[#780d25]">
                            {{ strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <span class="hidden text-sm font-semibold sm:block">
                            {{ auth()->user()->name ?? 'Administratrice' }}
                            <i class="fa-solid fa-chevron-down ml-1 text-xs text-[#806d76]"></i>
                        </span>
                    </div>
                </div>
            </header>

            <main class="flex-1 min-w-0 p-6">
                @yield('content')
                @yield('contenu')
            </main>
        </div>

    </div>

    <script>
        // Burger : affiche ou masque la sidebar (masquée par défaut sur petit écran)
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth < 1024) sidebar.classList.add('hidden');
        document.getElementById('burger').addEventListener('click', () => sidebar.classList.toggle('hidden'));
    </script>

</body>

</html>