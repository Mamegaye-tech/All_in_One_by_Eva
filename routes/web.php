
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RendezVousController;

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

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // CLIENTS

    // Export CSV (avant les routes resource)
    Route::get('clients/export', [ClientController::class, 'export'])
        ->name('clients.export');

    // Activation / désactivation
    Route::patch('clients/{client}/statut', [ClientController::class, 'toggleStatus'])
        ->name('clients.toggle-status');

    // Gestion complète des clients
    Route::resource('clients', ClientController::class);

    // RENDEZ-VOUS
    Route::resource('rendez-vous', RendezVousController::class);

});

// Route de débogage temporaire désactivée
// Route::get('/debug-output', function () {
//     $envoye = headers_sent($fichier, $ligne);
//     return "headers_sent : " . ($envoye ? 'OUI' : 'non');
// });
