<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;

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

    // Accueil administrateur
    Route::get('/accueil', [AccueilController::class, 'admin'])
        ->name('accueil.admin');

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // GESTION DES PRESTATIONS
    Route::resource('prestations', PrestationController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // CLIENTS

    // Export CSV (avant la route resource)
    Route::get('/clients/export', [ClientController::class, 'export'])
        ->name('clients.export');

    // Activation / désactivation
    Route::patch('/clients/{client}/statut', [ClientController::class, 'toggleStatus'])
        ->name('clients.toggle-status');

    // Gestion des clients (sans suppression définitive)
   Route::resource('clients', ClientController::class)->except(['destroy']);

Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
    ->name('clients.destroy');

    // RENDEZ-VOUS

    // Liste et création des rendez-vous uniquement
    Route::resource('rendez-vous', RendezVousController::class)
        ->only(['index', 'store']);

    // Changement de statut d'un rendez-vous
    Route::patch('/rendez-vous/{rendezVous}/statut', [RendezVousController::class, 'changerStatut'])
        ->name('rendez-vous.statut');

});