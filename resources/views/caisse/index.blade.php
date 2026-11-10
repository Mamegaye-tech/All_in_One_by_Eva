
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
                <h1 class="text-3xl font-bold text-[#780D35]">
                    Gestion de la caisse
                </h1>
                <p class="text-gray-600 mt-1">
                    Suivez les entrées et les sorties d'argent du salon.
                </p>
            </div>
        </div>

        <button class="bg-[#980044] hover:bg-[#780D35] text-white px-6 py-4 rounded-xl font-semibold shadow">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle opération
        </button>

    </div>


    <!-- CARTES STATISTIQUES -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <!-- SOLDE -->
        <div class="bg-[#F9DCE9] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#F5BBD3] text-[#980044] flex items-center justify-center text-3xl">
                <i class="fas fa-wallet"></i>
            </div>

            <div>
                <p class="text-gray-700">Solde de la caisse</p>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    270 000 <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>


        <!-- ENTREES -->
        <div class="bg-[#E5F2E9] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#CDE9D5] text-green-700 flex items-center justify-center text-3xl">
                <i class="fas fa-arrow-down"></i>
            </div>

            <div>
                <p class="text-gray-700">Total des entrées</p>
                <h2 class="text-2xl font-bold text-green-700">
                    450 000 <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>


        <!-- SORTIES -->
        <div class="bg-[#FBE1E6] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#F8C8D0] text-red-700 flex items-center justify-center text-3xl">
                <i class="fas fa-arrow-up"></i>
            </div>

            <div>
                <p class="text-gray-700">Total des sorties</p>
                <h2 class="text-2xl font-bold text-red-700">
                    180 000 <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>


        <!-- BENEFICE -->
        <div class="bg-[#F2DDF1] rounded-2xl p-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-[#EAC5E8] text-[#980044] flex items-center justify-center text-3xl">
                <i class="fas fa-chart-line"></i>
            </div>

            <div>
                <p class="text-gray-700">Bénéfice net</p>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    270 000 <span class="text-sm">FCFA</span>
                </h2>
            </div>
        </div>

    </div>


    <!-- HISTORIQUE -->
    <div class="bg-white rounded-2xl shadow-sm p-5">

        <!-- TITRE ET FILTRES -->
        <div class="flex flex-col xl:flex-row justify-between xl:items-center gap-4 mb-6">

            <div>
                <h2 class="text-2xl font-bold text-[#780D35]">
                    <i class="fas fa-clock-rotate-left mr-2"></i>
                    Historique des opérations
                </h2>

                <p class="text-gray-600 ml-9">
                    Consultez toutes les opérations de la caisse.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">

                <input type="date"
                    class="border border-gray-200 rounded-xl px-3 py-3 outline-none focus:border-[#980044]">

                <input type="date"
                    class="border border-gray-200 rounded-xl px-3 py-3 outline-none focus:border-[#980044]">

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

                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">09/11/2026</td>
                        <td class="p-4 border font-medium">Prestation coiffure</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">
                                Prestation
                            </span>
                        </td>
                        <td class="p-4 border">
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-arrow-down mr-1"></i> Entrée
                            </span>
                        </td>
                        <td class="p-4 border text-center font-semibold">50 000 FCFA</td>
                        <td class="p-4 border text-center">
                            <button class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full ml-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">08/11/2026</td>
                        <td class="p-4 border font-medium">Achat produits capillaires</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">
                                Stock
                            </span>
                        </td>
                        <td class="p-4 border">
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-arrow-up mr-1"></i> Sortie
                            </span>
                        </td>
                        <td class="p-4 border text-center font-semibold">30 000 FCFA</td>
                        <td class="p-4 border text-center">
                            <button class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full ml-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">07/11/2026</td>
                        <td class="p-4 border font-medium">Paiement client</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">
                                Prestation
                            </span>
                        </td>
                        <td class="p-4 border">
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-arrow-down mr-1"></i> Entrée
                            </span>
                        </td>
                        <td class="p-4 border text-center font-semibold">75 000 FCFA</td>
                        <td class="p-4 border text-center">
                            <button class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full ml-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">05/11/2026</td>
                        <td class="p-4 border font-medium">Entretien locaux</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">
                                Dépense
                            </span>
                        </td>
                        <td class="p-4 border">
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-arrow-up mr-1"></i> Sortie
                            </span>
                        </td>
                        <td class="p-4 border text-center font-semibold">20 000 FCFA</td>
                        <td class="p-4 border text-center">
                            <button class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full ml-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="hover:bg-[#FFF7FA]">
                        <td class="p-4 border">03/11/2026</td>
                        <td class="p-4 border font-medium">Prestation soin visage</td>
                        <td class="p-4 border">
                            <span class="bg-[#F9DCE9] text-[#780D35] px-4 py-2 rounded-full text-sm">
                                Prestation
                            </span>
                        </td>
                        <td class="p-4 border">
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-arrow-down mr-1"></i> Entrée
                            </span>
                        </td>
                        <td class="p-4 border text-center font-semibold">60 000 FCFA</td>
                        <td class="p-4 border text-center">
                            <button class="bg-[#F9DCE9] text-[#780D35] px-3 py-2 rounded-full">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="bg-[#F9DCE9] text-red-700 px-3 py-2 rounded-full ml-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-5">

            <p class="text-gray-600">
                Affichage de 1 à 5 sur 5 résultats
            </p>

            <div class="flex items-center gap-3">
                <button class="text-gray-600">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button class="bg-[#980044] text-white w-10 h-10 rounded-xl">
                    1
                </button>

                <button class="text-gray-600">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

        </div>

    </div>

</div>

@endsection
