@extends('layouts.app')

@section('title', 'Nouveau membre')
@section('sans_recherche', '1')

@section('content')
<div class="w-full max-w-2xl space-y-6">
    <h1 class="text-3xl font-bold text-[#780d25]">Nouveau membre</h1>

    <form method="POST" action="{{ route('equipe.store') }}"
          class="space-y-4 rounded-2xl bg-white p-6 shadow-[0_3px_10px_#e8d7df]">
        @csrf
        @include('equipe._form', ['employe' => null])

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('equipe.index') }}" class="rounded-xl bg-[#f3f4f6] px-5 py-3 text-sm text-gray-600 hover:bg-gray-200">Annuler</a>
            <button type="submit" class="rounded-xl bg-[#780d25] px-5 py-3 text-sm font-semibold text-white hover:opacity-90">Enregistrer</button>
        </div>
    </form>
</div>
@endsection