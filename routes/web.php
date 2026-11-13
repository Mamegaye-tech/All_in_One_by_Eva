<?php


    use App\Http\Controllers\AccueilController;
    use App\Http\Controllers\AnniversaireController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\CaisseController;
    use App\Http\Controllers\CampagneController;
    use App\Http\Controllers\ClientController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\DepenseController;
    use App\Http\Controllers\EquipeController;
    use App\Http\Controllers\ParametreController;
    use App\Http\Controllers\PrestationController;
    use App\Http\Controllers\RapportController;
    use App\Http\Controllers\RendezVousController;
    use App\Http\Controllers\StockController;
    use Illuminate\Support\Facades\Route;

    // Page d'accueil
    Route::redirect('/', '/dashboard');

// AUTHENTIFICATION
Route::middleware('guest')->group(function () {

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
        // Accueil admin
        Route::get('/accueil', [AccueilController::class, 'admin'])
            ->name('accueil.admin');

        // Déconnexion
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        // GESTION DES PRESTATIONS
        Route::resource('prestations', PrestationController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // CLIENTS

    Route::get('/clients/export', [ClientController::class, 'export'])
        ->name('clients.export');

    Route::patch('/clients/{client}/statut', [ClientController::class, 'toggleStatus'])
        ->name('clients.toggle-status');

    Route::resource('clients', ClientController::class)
        ->except(['destroy']);

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
        ->name('clients.destroy');
        // Export CSV (avant les routes resource)
        Route::get('clients/export', [ClientController::class, 'export'])
            ->name('clients.export');

        // Activation / désactivation
        Route::patch('clients/{client}/statut', [ClientController::class, 'toggleStatus'])
            ->name('clients.toggle-status');

        // Gestion complète des clients
        Route::resource('clients', ClientController::class);

        // RENDEZ-VOUS
        Route::resource('rendez-vous', RendezVousController::class)
            ->only(['index', 'store']);

        Route::patch('/rendez-vous/{rendezVous}/statut', [RendezVousController::class, 'changerStatut'])
            ->name('rendez-vous.statut');

    // CAISSE
    Route::get('/caisse', [CaisseController::class, 'index'])
        ->name('caisse.index');

});
        // CAISSE
        Route::get('/caisse', [CaisseController::class, 'index'])
            ->name('caisse.index');

        Route::post('/caisse', [CaisseController::class, 'store'])
            ->name('caisse.store');

        Route::get('/caisse/{paiement}', [CaisseController::class, 'show'])
            ->name('caisse.show');

        // DÉPENSES
        Route::resource('depenses', DepenseController::class)
            ->except(['show']);

        // STOCK
        Route::resource('stock', StockController::class)
            ->except(['show']);

    
    // Ajustement du stock
    Route::post('/stock/{produit}/ajuster', [StockController::class, 'ajuster'])
        ->name('stock.ajuster');

    // Historique des mouvements d'un produit
    Route::get('/stock/{stock}/mouvement', [StockController::class, 'mouvement'])
        ->name('stock.mouvement');

           // ANNIVERSAIRES
    Route::get('/anniversaires', [AnniversaireController::class, 'index'])
        ->name('anniversaires.index');

    Route::post('/anniversaires/{client}', [AnniversaireController::class, 'store'])
        ->name('anniversaires.store');

    Route::delete('/anniversaires/{anniversaire}', [AnniversaireController::class, 'destroy'])
        ->name('anniversaires.destroy');

       // CAMPAGNES
Route::resource('campagnes', CampagneController::class)
    ->only(['index', 'create', 'store', 'show', 'destroy']);

Route::patch('campagnes/{campagne}/destinataires/{destinataire}/suivi',
    [CampagneController::class, 'basculerSuivi'])
    ->name('campagnes.destinataires.suivi');

        // RAPPORTS
        Route::get('/rapports', [RapportController::class, 'index'])
            ->name('rapports.index');

        Route::get('/rapports/export', [RapportController::class, 'export'])
            ->name('rapports.export');

        // ÉQUIPE (employés)
        Route::resource('equipe', EquipeController::class)
            ->parameters(['equipe' => 'employe'])
            ->except(['show']);

        // PARAMÈTRES
        Route::get('/parametres', [ParametreController::class, 'index'])
            ->name('parametres.index');

        Route::put('/parametres', [ParametreController::class, 'update'])
            ->name('parametres.update');

    });
