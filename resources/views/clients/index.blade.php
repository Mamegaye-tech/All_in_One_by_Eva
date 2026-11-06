@extends('layouts.app')

@section('content')
<div>

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-[#700D29]">Clients</h1>

        <a href="{{ route('clients.create') }}"
           class="bg-[#700D29] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:opacity-90 transition">
            <i class="fas fa-plus mr-1"></i> Nouveau client
        </a>
    </div>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Recherche -->
    <form method="GET" action="{{ route('clients.index') }}" class="mb-4">
        <div class="flex items-center border border-gray-200 rounded-xl px-4 bg-white w-full md:w-96">
            <i class="fas fa-magnifying-glass text-[#700D29]"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un client..."
                   class="w-full p-2 outline-none bg-transparent text-sm">
        </div>
    </form>

    <!-- Tableau -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#FFF0F4] text-[#700D29]">
                <tr>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($clients as $client)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $client->prenom }} {{ $client->nom }}</td>
                        <td class="px-4 py-3">{{ $client->telephone }}</td>
                        <td class="px-4 py-3">{{ $client->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('clients.show', $client) }}"
                               class="text-[#700D29] hover:underline">Voir</a>
                            <a href="{{ route('clients.edit', $client) }}"
                               class="text-[#700D29] hover:underline">Modifier</a>

                            <form method="POST" action="{{ route('clients.destroy', $client) }}"
                                  class="inline"
                                  onsubmit="return confirm('Archiver ce client ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Archiver</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                            Aucun client trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $clients->links() }}
    </div>

</div>
@endsection