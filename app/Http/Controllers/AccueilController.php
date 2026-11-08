<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\RendezVous;
use Illuminate\View\View;

class AccueilController extends Controller
{
    public function admin(): View
    {
        $stats = [
            
            'clients'  => Client::count(),
            'rdv_jour' => RendezVous::whereDate('debut', today())->count(),
            'ca_jour'  => 450000,   // valeur fixe pour l'instant
            'depenses' => 180000,   // valeur fixe pour l'instant
        ];

        return view('accueil.admin', compact('stats'));
    }
}