@extends('layouts.app')
@section('title', 'Nouveau client')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-2xl font-semibold text-[#780D25]">Nouveau client</h1>
    <form method="POST" action="{{ route('clients.store') }}" class="rounded-xl bg-white p-6 shadow-sm">
        @include('clients._form')
    </form>
</div>
@endsection