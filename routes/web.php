<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\AccueilController;

// Page d'accueil
Route::redirect('/', '/dashboard');


// AUTHENTIFICATION
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.attempt');

});

// ESPACE ADMINISTRATION
Route::middleware(['auth', 'actif'])->group(function () {

    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // DÃ©connexion
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // CLIENTS

    // Export CSV (avant les routes resource)
    Route::get('clients/export', [ClientController::class, 'export'])
        ->name('clients.export');

    // Activation / dÃ©sactivation
    Route::patch('clients/{client}/statut', [ClientController::class, 'toggleStatus'])
        ->name('clients.toggle-status');

    // Gestion complÃ¨te des clients
    Route::resource('clients', ClientController::class);

    // RENDEZ-VOUS
    Route::resource('rendez-vous', RendezVousController::class);
    Route::get('/accueil', [AccueilController::class, 'admin'])->name('accueil.admin');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('clients', ClientController::class);

    Route::resource('rendez-vous', RendezVousController::class)->only(['index', 'store']);
    Route::patch('/rendez-vous/{rendezVous}/statut', [RendezVousController::class, 'changerStatut'])
        ->name('rendez-vous.statut');
});

// Route de dÃ©bogage temporaire dÃ©sactivÃ©e
// Route::get('/debug-output', function () {
//     $envoye = headers_sent($fichier, $ligne);
//     return "headers_sent : " . ($envoye ? 'OUI' : 'non');
// });
