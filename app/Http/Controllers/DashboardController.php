<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\RendezVous;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'clients'  => Client::count(),
            'rdv_jour' => RendezVous::whereDate('date', today())->count(),
            'ca_jour'  => 450000,   // valeur fixe pour l'instant
            'depenses' => 180000,   // valeur fixe pour l'instant
        ];

        return view('dashboard.index', compact('stats'));
    }
}