@extends('layouts.app')
@section('title', 'Modifier l\'employé')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-2xl font-semibold text-[#780D25]">Modifier {{ $employe->nom_complet }}</h1>
    <form method="POST" action="{{ route('employes.update', $employe) }}" class="rounded-xl bg-white p-6 shadow-sm">
        @method('PUT')
        @include('employes._form')
    </form>
</div>
@endsection