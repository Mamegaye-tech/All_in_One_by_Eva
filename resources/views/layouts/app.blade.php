
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All in One by Eva</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

                <!-- Tableau de bord -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl bg-[#C52F6C]">
                    <i class="fas fa-house w-6 text-lg"></i>
                    <span>Tableau de bord</span>
                </a>

                <!-- Clients -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-users w-6 text-lg"></i>
                    <span>Clients</span>
                </a>

                <!-- Rendez-vous -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-calendar-days w-6 text-lg"></i>
                    <span>Rendez-vous</span>
                </a>

                <!-- Prestations -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-spa w-6 text-lg"></i>
                    <span>Prestations</span>
                </a>

                <!-- Caisse -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-briefcase w-6 text-lg"></i>
                    <span>Caisse</span>
                </a>

                <!-- Dépenses -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-sack-dollar w-6 text-lg"></i>
                    <span>Dépenses</span>
                </a>

                <!-- Produits et stock -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-boxes-stacked w-6 text-lg"></i>
                    <span>Stock</span>
                </a>

                <!-- Anniversaires -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-cake-candles w-6 text-lg"></i>
                    <span>Anniversaires</span>
                </a>

                <!-- Promotions -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-gift w-6 text-lg"></i>
                    <span>Campagnes</span>
                </a>

                <!-- Rapports -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-chart-column w-6 text-lg"></i>
                    <span>Rapports</span>
                </a>

                <!-- Employés -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-user-tie w-6 text-lg"></i>
                    <span>Equipe</span>
                </a>

                <!-- Paramètres -->
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
                    <i class="fas fa-gear w-6 text-lg"></i>
                    <span>Paramètres</span>
                </a>

            </nav>

            <!-- DECONNEXION -->
            <div class="border-t border-pink-300/40 pt-3 mt-3">

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">

                    <i class="fas fa-right-from-bracket w-6 text-lg"></i>

                    <span>Déconnexion</span>

                </a>

            </div>

        </aside>

        <!-- CONTENU PRINCIPAL -->
        <main class="flex-1 min-w-0 p-6">

            @yield('content')

        </main>

    </div>

</body>

</html>

