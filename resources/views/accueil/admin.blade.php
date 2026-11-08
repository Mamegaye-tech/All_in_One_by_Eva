<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accueil - All in One by Eva</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #fdeef4; color: #321b25; }

        .page { max-width: 430px; margin: 0 auto; min-height: 100vh; padding: 18px 18px 90px; }

        /* En-tête */
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; }
        .header button { background: none; border: none; font-size: 22px; color: #321b25; cursor: pointer; }
        .header img { height: 56px; }

        /* Bienvenue */
        .welcome h1 { font-size: 22px; margin-bottom: 6px; }
        .welcome p { color: #806d76; font-size: 14px; margin-bottom: 24px; }

        /* Cartes */
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .card {
            background: #fff; border-radius: 18px; padding: 22px 10px;
            box-shadow: 0 4px 12px #efd9e2;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
        }
        .card i { font-size: 26px; color: #a51c50; }
        .card strong { font-size: 24px; }
        .card span { font-size: 13px; color: #806d76; }

        /* Barre du bas */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0;
            max-width: 430px; margin: 0 auto;
            background: #fff; border-top: 1px solid #f0dfe7;
            display: flex; justify-content: space-around; padding: 10px 0;
        }
        .bottom-nav a {
            display: flex; flex-direction: column; align-items: center; gap: 3px;
            font-size: 11px; color: #806d76; text-decoration: none;
        }
        .bottom-nav a i { font-size: 19px; }
        .bottom-nav a.active { color: #780d25; font-weight: bold; }
    </style>
</head>
<body>
<div class="page">

    <header class="header">
        <button aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
        <img src="{{ asset('images/logo.png') }}" alt="All in One by Eva">
        <button aria-label="Filtres"><i class="fa-solid fa-sliders"></i></button>
    </header>

    <div class="welcome">
        <h1>Bonjour, Administratrice 👋</h1>
        <p>Bienvenue sur votre espace !</p>
    </div>

    <div class="stats">
        <div class="card">
            <i class="fa-solid fa-users"></i>
            <strong>{{ number_format($stats['clients'], 0, ',', ' ') }}</strong>
            <span>Clients</span>
        </div>
        <div class="card">
            <i class="fa-regular fa-calendar-days"></i>
            <strong>{{ $stats['rdv_jour'] }}</strong>
            <span>RDV du jour</span>
        </div>
        <div class="card">
            <i class="fa-solid fa-chart-line"></i>
            <strong>{{ number_format($stats['ca_jour'] / 1000, 0) }}k</strong>
            <span>CA du jour</span>
        </div>
        <div class="card">
            <i class="fa-solid fa-wallet"></i>
            <strong>{{ number_format($stats['depenses'] / 1000, 0) }}k</strong>
            <span>Dépenses</span>
        </div>
    </div>

</div>

<nav class="bottom-nav">
    <a href="{{ route('accueil.admin') }}" class="active"><i class="fa-solid fa-house"></i>Accueil</a>
    <a href="{{ route('clients.index') }}"><i class="fa-solid fa-users"></i>Clients</a>
    <a href="#"><i class="fa-regular fa-calendar-days"></i>RDV</a>
    <a href="{{ route('dashboard') }}"><i class="fa-solid fa-ellipsis"></i>Plus</a>
</nav>
</body>
</html>