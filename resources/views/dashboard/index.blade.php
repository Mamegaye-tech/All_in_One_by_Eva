@extends('layouts.guest')

@section('titre', 'Tableau de bord')

@section('contenu')
<div class="mx-auto max-w-2xl px-4 py-16">
    <h1 class="font-script text-5xl text-bordeaux">All in One by Eva</h1>

    <p class="mt-6">
        Bonjour {{ auth()->user()->name }}, vous êtes connecté(e) en tant que
        <strong>{{ auth()->user()->role?->libelle ?? 'sans rôle' }}</strong>.
    </p>
    <p class="mt-2 text-sm text-encre/60">Page provisoire : le vrai tableau de bord arrive à l’étape 4.</p>

    <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button class="rounded-lg border border-bordeaux px-4 py-2 text-sm text-bordeaux hover:bg-bordeaux-soft">
            Se déconnecter
        </button>
    </form>
</div>
@endsection