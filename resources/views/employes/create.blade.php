@extends('layouts.app')
@section('title', 'Nouvel employé')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-2xl font-semibold text-[#780D25]">Nouvel employé</h1>
    <form method="POST" action="{{ route('employes.store') }}" class="rounded-xl bg-white p-6 shadow-sm">
        @include('employes._form')
    </form>
</div>
@endsection