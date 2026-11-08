<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\AccueilController;



Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.attempt');
});

 Route::get('/sidebar', function () {
    return view('layouts.app');
    });

// ESPACE ADMINISTRATION
Route::middleware(['auth', 'actif'])->group(function () {

    Route::get('/accueil', [AccueilController::class, 'admin'])->name('accueil.admin');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('clients', ClientController::class);

    Route::resource('rendez-vous', RendezVousController::class)->only(['index', 'store']);
    Route::patch('/rendez-vous/{rendezVous}/statut', [RendezVousController::class, 'changerStatut'])
        ->name('rendez-vous.statut');
});

  

// Route::get('/debug-session', fn () => [
//     'session_id'  => session()->getId(),
//     'connecte'    => auth()->check(),
//     'user_id'     => auth()->id(),
//     'cle_login'   => collect(session()->all())->keys()->filter(fn ($k) => str_starts_with($k, 'login_'))->values(),
//     'driver'      => config('session.driver'),
//     'secure'      => config('session.secure'),
//     'domain'      => config('session.domain'),
//     'modele_auth' => config('auth.providers.users.model'),
// ]);
