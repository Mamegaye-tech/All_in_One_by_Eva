<?php

namespace App\Http\Controllers;

use App\Models\CampagneMessage;

class RapportController extends Controller
{
    public function index()
    {
        $campagnes = CampagneMessage::withCount([
            'destinataires',
            'destinataires as suivis_count' => fn ($q) => $q->whereNotNull('suivi_manuel'),
        ])->latest()->get();

        $totalDestinataires = $campagnes->sum('destinataires_count');
        $totalSuivis = $campagnes->sum('suivis_count');

        return view('rapports.index', compact('campagnes', 'totalDestinataires', 'totalSuivis'));
    }
}