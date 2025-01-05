<?php

use App\Http\Controllers\DemandeMaintenanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentImmobilierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportListePDF;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\PaiementController;



Route::get('/', function () {
    return view('welcome');
});
//  GEstion de la langue local
Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'es', 'de', 'fr'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('change.language');

// Assurez-vous que cette route est placée AVANT les routes resource
Route::get('/locataire/{id}/locainformations', [LocataireController::class, 'showInformations'])
    ->name('locataire.locainformations');

Route::get('/locataire/{id}/agentinfo', [LocataireController::class, 'showAgentInfo'])
->name('locataire.agentinfo');

// noté agence
Route::put('/agent/evaluation/{id}', [AgentImmobilierController::class, 'updateEvaluation'])
->name('agent.updateEvaluation');







// La route resource existante
Route::resource('locataire', LocataireController::class);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('layouts.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('/agent-immobilier', AgentImmobilierController::class)->names('agent_immobilier');
//route pour le changement de mot de passe pour new locataire
Route::get('/password_change', [LocataireController::class, 'showChangePasswordForm'])->name('passwordChangeForm');
Route::post('/password_change_save', [LocataireController::class, 'changePassword'])->name('passwordChangeFormSave');
//route pour changer le statut du locataire par l'agent immobilier

//Route pour l'exportation de la liste des locataire en pdf

Route::get('/export/pdf', [ExportListePDF::class, 'exportPdf'])->name('export.pdf');

// Routes pour les paiements (uniquement avec auth)
Route::middleware(['auth'])->group(function () {
    // Historique des paiements
    Route::get('/locataire/paiements/historique', [PaiementController::class, 'historique'])
        ->name('locataire.paiements.historique');
    
    
        
    Route::post('/locataire/paiements/store', [PaiementController::class, 'store'])
        ->name('locataire.paiements.store');
    

    Route::post('/locataire/paiements/create', [PaiementController::class, 'create'])
    ->name('locataire.paiements.create');
    
    // Route pour la quittance de loyer
    Route::get('/locataire/paiements/{id}/quittance', [PaiementController::class, 'generateQuittance'])
        ->name('locataire.paiements.quittance');

    Route::get('/locataire/paiements/{id}/details', [PaiementController::class, 'show'])
    ->name('locataire.paiements.show');







    Route::middleware(['auth'])->group(function() {
        // Afficher le formulaire de demande de maintenance
        Route::get('/demande-maintenance/create', [DemandeMaintenanceController::class, 'create'])->name('demandes.create');
    
        // Soumettre la demande
        Route::post('/demande-maintenance', [DemandeMaintenanceController::class, 'store'])->name('demandes.store');
        // Afficher les demandes de maintenance soumises par le locataire
        Route::get('/mes-demandes', [DemandeMaintenanceController::class, 'index'])->name('demandes.index');
        //AGENT CONSULTE LES DEMANDES
        Route::get('/agent_demande', [DemandeMaintenanceController::class, 'showAgentDemands'])->name('agent_demande');
    
    });

   
// Routes pour les agents immobiliers
Route::post('/admin/agents/toggle-status/{id}', [AgentImmobilierController::class, 'toggleStatus'])->name('admin.agents.toggleStatus');


// Routes pour les locataires
Route::prefix('locataires')->group(function () {
    Route::post('/{id}/toggle-status', [LocataireController::class, 'toggleStatus']);
});
    Route::get('/admin/agents/index', [AgentImmobilierController::class, 'index'])->name('admin.agents.index');
Route::get('/admin/agents/{id}', [AgentImmobilierController::class, 'show'])->name('admin.agents.show');
Route::patch('/agents/{id}/update-status', [AgentImmobilierController::class, 'updateStatus'])->name('agents.updateStatus');


   
});







