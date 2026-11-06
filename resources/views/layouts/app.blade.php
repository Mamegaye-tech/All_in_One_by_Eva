<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All in One by Eva</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
         

    @stack('styles')
</head>
</head>

<body class="bg-[#FFF8FA]">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 h-screen sticky top-0 bg-[#700D29] text-white flex flex-col px-4 py-4">

            <!-- LOGO -->
            <div class="text-center mb-5 border-b border-pink-300/40 pb-3">
                <img src="{{ asset('images/logo1.png') }}"
                     alt="All in One by Eva"
                     class="w-28 mx-auto h-auto">
            </div>

            <!-- MENU -->
            <nav class="flex-1 space-y-2 text-sm overflow-y-auto pt-1">

                <x-nav-link route="dashboard" icon="fa-house">Tableau de bord</x-nav-link>

                <x-nav-link route="clients.index" pattern="clients.*" icon="fa-users">Clients</x-nav-link>

                <x-nav-link route="rendez-vous.index" pattern="rendez-vous.*" icon="fa-calendar-days">Rendez-vous</x-nav-link>

                <x-nav-link route="#" icon="fa-spa">Prestations</x-nav-link>

                <x-nav-link route="#" icon="fa-briefcase">Caisse</x-nav-link>

                <x-nav-link route="#" icon="fa-sack-dollar">Dépenses</x-nav-link>

                <x-nav-link route="#" icon="fa-boxes-stacked">Stock</x-nav-link>

                <x-nav-link route="#" icon="fa-cake-candles">Anniversaires</x-nav-link>

                <x-nav-link route="#" icon="fa-gift">Campagnes</x-nav-link>

                <x-nav-link route="#" icon="fa-chart-column">Rapports</x-nav-link>

                <x-nav-link route="#" icon="fa-user-tie">Equipe</x-nav-link>

                <x-nav-link route="#" icon="fa-gear">Paramètres</x-nav-link>

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
        <main class="flex-1 min-w-0 p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>