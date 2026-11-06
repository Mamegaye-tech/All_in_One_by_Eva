<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Route::get('/debug-output', function () {
//     $envoye = headers_sent($fichier, $ligne);

//     return "headers_sent : " . ($envoye ? 'OUI' : 'non') . "<br>Fichier : {$fichier}<br>Ligne : {$ligne}";
// });


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
Route::middleware(['auth','actif'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

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
