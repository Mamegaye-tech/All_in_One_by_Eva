@extends('layouts.guest')

@section('titre', 'Connexion')

@section('contenu')
<div class="grid min-h-screen lg:grid-cols-2">

    {{-- Partie gauche : image et nom du salon --}}
    <div class="relative hidden items-center justify-center overflow-hidden bg-rose-soft lg:flex"
         style="background-image: linear-gradient(rgba(252,243,246,.55), rgba(252,243,246,.55)), url('{{ asset('images/login-bg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="px-10 text-center">
            @if (file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="All in One by Eva" class="mx-auto mb-4 h-40 w-auto">
            @endif
            <h1 class="font-script text-7xl leading-tight text-bordeaux">All in One<br><span class="text-5xl">by Eva</span></h1>
            <p class="mt-6 text-lg font-medium text-encre">Beauté • Bien-être • Élégance</p>
            <p class="mt-8 font-serif text-xl italic text-bordeaux/80">
                Prenez soin de vous,<br>nous nous occupons du reste ♡
            </p>
        </div>
    </div>

    {{-- Partie droite : formulaire --}}
    <div class="flex items-center justify-center bg-creme px-4 py-10">
        <div class="w-full max-w-md">

            {{-- Nom visible sur mobile (la partie gauche est masquée) --}}
            <div class="mb-6 text-center lg:hidden">
                <h1 class="font-script text-5xl text-bordeaux">All in One by Eva</h1>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-lg shadow-bordeaux/10">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-semibold">Connexion</h2>
                    <p class="mt-1 text-sm text-encre/70">Accédez à votre espace</p>
                </div>

                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5" id="form-login">
                    @csrf

                    <div>
                        <label for="email" class="sr-only">Adresse e-mail</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               placeholder="Adresse e-mail"
                               required autofocus autocomplete="username"
                               class="w-full rounded-lg border border-beige-dark/50 bg-white px-3 py-3 text-sm outline-none focus:border-bordeaux focus:ring-2 focus:ring-bordeaux/20">
                        @error('email')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sr-only">Mot de passe</label>
                        <div class="relative">
                            <input id="password" name="password" type="password"
                                   placeholder="Mot de passe"
                                   required autocomplete="current-password"
                                   class="w-full rounded-lg border border-beige-dark/50 bg-white px-3 py-3 pr-12 text-sm outline-none focus:border-bordeaux focus:ring-2 focus:ring-bordeaux/20">
                            <button type="button" id="toggle-password"
                                    class="absolute inset-y-0 right-0 px-3 text-xs font-medium text-bordeaux">
                                Voir
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remember" class="rounded border-beige-dark text-bordeaux focus:ring-bordeaux">
                        Se souvenir de moi
                    </label>

                    <button type="submit" id="btn-login"
                            class="w-full rounded-lg bg-bordeaux px-4 py-3 text-sm font-semibold text-white transition hover:bg-bordeaux-dark disabled:opacity-60">
                        Se connecter →
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-encre/50">All in One by Eva © {{ date('Y') }}</p>
        </div>
    </div>
</div>

<script>
    // Afficher / masquer le mot de passe
    document.getElementById('toggle-password').addEventListener('click', function () {
        const champ = document.getElementById('password');
        const visible = champ.type === 'text';
        champ.type = visible ? 'password' : 'text';
        this.textContent = visible ? 'Voir' : 'Masquer';
    });

    // État de chargement : évite le double clic pendant l'envoi
    document.getElementById('form-login').addEventListener('submit', function () {
        const b = document.getElementById('btn-login');
        b.disabled = true;
        b.textContent = 'Connexion en cours…';
    });
</script>
@endsection