
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

<body class="bg-[#F8F4F0]">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-[#780D25] text-white flex flex-col p-5">

        <!-- LOGO -->
        <div class="mb-10 text-center">
            <h1 class="text-2xl font-bold tracking-wide">
                All in One
            </h1>
            <p class="text-pink-200 text-sm italic">
                by Eva
            </p>
        </div>

        <!-- MENU -->
        <nav class="flex-1 space-y-2">

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-white/20">
                <i class="fas fa-chart-pie w-5"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-users w-5"></i>
                <span>Clients</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-calendar-days w-5"></i>
                <span>Rendez-vous</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-spa w-5"></i>
                <span>Prestations</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-user-tie w-5"></i>
                <span>Employés</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-wallet w-5"></i>
                <span>Paiements</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-money-bill-wave w-5"></i>
                <span>Dépenses</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-boxes-stacked w-5"></i>
                <span>Stocks</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-cake-candles w-5"></i>
                <span>Anniversaires</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-gift w-5"></i>
                <span>Fidélité</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fab fa-whatsapp w-5"></i>
                <span>Campagnes WhatsApp</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-chart-line w-5"></i>
                <span>Rapports</span>
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-gear w-5"></i>
                <span>Paramètres</span>
            </a>

        </nav>

        <!-- DECONNEXION -->
        <div class="border-t border-white/20 pt-5 mt-5">
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/20">
                <i class="fas fa-right-from-bracket w-5"></i>
                <span>Déconnexion</span>
            </a>
        </div>

    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>
