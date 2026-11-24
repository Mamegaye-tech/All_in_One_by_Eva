@extends('layouts.app')

@section('contenu')

<div class="min-h-screen bg-[#F8F4F7] p-6">

    <!-- EN-TÊTE -->
    <div class="flex items-center justify-between mb-7">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#780D35] text-white flex items-center justify-center text-3xl">
                <i class="fas fa-sack-dollar"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-[#780D35]">Gestion de la caisse</h1>
                <p class="text-gray-600 mt-1">Suivez les entrées et les sorties d'argent du salon.</p>
            </div>
        </div>

        <button type="button" onclick="ouvrirAjout()" class="bg-[#980044] hover:bg-[#780D35] text-white px-6 py-4 rounded-xl font-semibold shadow cursor-pointer">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle opération
        </button>
    </div>

    <!-- CARTES STATISTIQUES -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-[#F9DCE9] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#F5BBD3] text-[#980044] flex items-center justify-center text-3xl">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <p class="text-gray-700">Solde de la caisse</p>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    {{ number_format($solde, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>

        <div class="bg-[#E5F2E9] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#CDE9D5] text-green-700 flex items-center justify-center text-3xl">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <p class="text-gray-700">Total des entrées</p>
                <h2 class="text-2xl font-bold text-green-700">
                    {{ number_format($entrees, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>

        <div class="bg-[#FBE1E6] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#F8C8D0] text-red-700 flex items-center justify-center text-3xl">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <p class="text-gray-700">Total des sorties</p>
                <h2 class="text-2xl font-bold text-red-700">
                    {{ number_format($sorties, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>

        <div class="bg-[#F2DDF1] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#EAC5E8] text-[#980044] flex items-center justify-center text-3xl">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <p class="text-gray-700">Bénéfice net</p>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    {{ number_format($solde, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>

    </div>

    <!-- HISTORIQUE -->
    <div class="bg-white rounded-2xl shadow-sm p-5">

        <div class="flex flex-col xl:flex-row justify-between xl:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    <i class="fas fa-clock-rotate-left mr-2"></i>
                    Historique des opérations
                </h2>
                <p class="text-gray-600 ml-9">Consultez toutes les opérations de la caisse.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <input type="date" class="border border-gray-200 rounded-xl px-3 py-3 outline-none focus:border-[#980044]">
                <input type="date" class="border border-gray-200 rounded-xl px-3 py-3 outline-none focus:border-[#980044]">
                <select class="border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#980044]">
                    <option>Toutes les opérations</option>
                    <option>Entrées</option>
                    <option>Sorties</option>
                </select>
            </div>
        </div>

        <!-- TABLEAU -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">

                <thead>
                    <tr class="bg-[#F9DCE9] text-[#780D35]">
                        <th class="p-4 border border-[#F0D5E0]">Date</th>
                        <th class="p-4 border border-[#F0D5E0]">Désignation</th>
                        <th class="p-4 border border-[#F0D5E0]">Catégorie</th>
                        <th class="p-4 border border-[#F0D5E0]">Type</th>
                        <th class="p-4 border border-[#F0D5E0] text-center">Montant</th>
                        <th class="p-4 border border-[#F0D5E0] text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">
                    @forelse($operations as $op)
                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">{{ $op->date->format('d/m/Y') }}</td>
                        <td class="p-4 border font-medium">{{ $op->designation }}</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">{{ $op->categorie }}</span>
                        </td>
                        <td class="p-4 border">
                            @if($op->type === 'entree')
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm"><i class="fas fa-arrow-down mr-1"></i> Entrée</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm"><i class="fas fa-arrow-up mr-1"></i> Sortie</span>
                            @endif
                        </td>
                        <td class="p-4 border text-center font-semibold">{{ number_format($op->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="p-4 border text-center">
                            <div class="flex items-center justify-center gap-2">

                                <button type="button" onclick="voirOperation(this)"
                                    data-date="{{ $op->date->format('d/m/Y') }}"
                                    data-designation="{{ $op->designation }}"
                                    data-categorie="{{ $op->categorie }}"
                                    data-type="{{ $op->type === 'entree' ? 'Entrée' : 'Sortie' }}"
                                    data-montant="{{ number_format($op->montant, 0, ',', ' ') }} FCFA"
                                    class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full cursor-pointer">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <form action="{{ route('caisse.destroy', $op) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette opération ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full cursor-pointer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-6 text-center text-gray-500">Aucune opération pour le moment.</td></tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- COMPTEUR -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-5">
            <p class="text-gray-600">Affichage de {{ $operations->count() }} résultat(s)</p>
        </div>

    </div>

</div>

<!-- FENÊTRE DE DÉTAILS -->
<div id="modalVoir" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md">
        <h2 class="text-xl font-bold text-[#780D35] mb-4">Détails de l'opération</h2>

        <dl class="space-y-2">
            <div class="flex justify-between"><dt class="text-gray-500">Date</dt><dd id="voirDate" class="font-medium"></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Désignation</dt><dd id="voirDesignation" class="font-medium"></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Catégorie</dt><dd id="voirCategorie" class="font-medium"></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Type</dt><dd id="voirType" class="font-medium"></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Montant</dt><dd id="voirMontant" class="font-bold text-[#780D35]"></dd></div>
        </dl>

        <div class="flex justify-end mt-5">
            <button type="button" onclick="fermerVoir()" class="px-4 py-2 rounded-xl bg-[#980044] text-white cursor-pointer">Fermer</button>
        </div>
    </div>
</div>

<!-- FENÊTRE NOUVELLE OPÉRATION -->
<div id="modalAjout" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <form action="{{ route('caisse.store') }}" method="POST" class="bg-white rounded-2xl p-6 w-full max-w-md space-y-3">
        @csrf

        <h2 class="text-xl font-bold text-[#780D35]">Nouvelle opération</h2>

        @if($errors->any())
            <p class="text-red-600 text-sm">{{ $errors->first() }}</p>
        @endif

        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full border rounded-xl px-3 py-2">
        <input type="text" name="designation" placeholder="Désignation" required class="w-full border rounded-xl px-3 py-2">
        <input type="text" name="categorie" placeholder="Catégorie (Prestation, Stock, Dépense...)" required class="w-full border rounded-xl px-3 py-2">
        <select name="type" required class="w-full border rounded-xl px-3 py-2">
            <option value="entree">Entrée</option>
            <option value="sortie">Sortie</option>
        </select>
        <input type="number" name="montant" placeholder="Montant (FCFA)" min="0" required class="w-full border rounded-xl px-3 py-2">

        <div class="flex justify-end gap-3 pt-2">
            <button type="button" onclick="fermerAjout()" class="px-4 py-2 rounded-xl border cursor-pointer">Annuler</button>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#980044] text-white cursor-pointer">Enregistrer</button>
        </div>
    </form>
</div>

<script>
function voirOperation(btn) {
    document.getElementById('voirDate').textContent = btn.dataset.date;
    document.getElementById('voirDesignation').textContent = btn.dataset.designation;
    document.getElementById('voirCategorie').textContent = btn.dataset.categorie;
    document.getElementById('voirType').textContent = btn.dataset.type;
    document.getElementById('voirMontant').textContent = btn.dataset.montant;
    document.getElementById('modalVoir').classList.remove('hidden');
}
function fermerVoir() {
    document.getElementById('modalVoir').classList.add('hidden');
}
function ouvrirAjout() {
    document.getElementById('modalAjout').classList.remove('hidden');
}
function fermerAjout() {
    document.getElementById('modalAjout').classList.add('hidden');
}
</script>

@endsection