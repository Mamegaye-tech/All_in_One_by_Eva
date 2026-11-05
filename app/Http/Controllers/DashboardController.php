<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        // dd('Dashboard atteint', auth()->check(), auth()->id());

        return view('dashboard.dashboard');
    }
}

