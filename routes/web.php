<?php

use App\Http\Controllers\DemandeMaintenanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentImmobilierController;
use App\Http\Controllers\ArticleContratBailController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\ContratDeBailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportListePDF;
use App\Http\Controllers\LocataireBienController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ActionAdminController;
use App\Http\Controllers\NotificationController;
use Chatify\Http\Controllers\CustomMessagesController;

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


// route modifiez mon prodfill locataire

Route::get('/locataire/{id}/locashow', [LocataireController::class, 'showInformations'])
    ->name('locataire.locashow');

Route::get('/locataire/{id}/locatairebien', [LocataireController::class, 'showlocatairebien'])
    ->name('locataire_bien');

Route::middleware(['auth'])->group(function () {


    // Assurez-vous que cette route est placée AVANT les routes resource
    Route::get('/locataire/agentinfo', [LocataireController::class, 'agenceImmobiliereAssociee'])->name('locataire.agentinfo');
});
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

require __DIR__ . '/auth.php';


Route::resource('/agent-immobilier', AgentImmobilierController::class)->names('agent_immobilier');

Route::resource('/biens', BienController::class)->names('biens');
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

    Route::get('/locataire/paiements/{id}/detail', [PaiementController::class, 'show'])->name('locataire.paiements.detail');
    Route::get('/agent/paiements/{id}/detail', [PaiementController::class, 'show'])->name('agent_historique_detail');
});


/// ROUTE SUCCESIVE POUR GERER PAIEMENT

/// ROUTE 1

Route::get('/periodes', [PaiementController::class, 'trouverPeriode'])->name('periodes.show');

/// ROUTE 2
Route::get('/paiement/partiepaiement', [PaiementController::class, 'partiepaiement'])->name('paiement.partiepaiement');
Route::post('/paiement/complement', [PaiementController::class, 'ajouterComplement'])->name('paiement.complement');





Route::middleware(['auth'])->group(function () {
    // Afficher le formulaire de demande de maintenance
    Route::get('/locataire/demandes/create', [DemandeMaintenanceController::class, 'create'])->name('locataire.demandes.create');


    // Enregistrer la demande de maintenance
    Route::post('/locataire/demandes', [DemandeMaintenanceController::class, 'store'])->name('locataire.demandes.store');

    // Voir la liste des demandes de maintenance du locataire
    Route::get('/locataire/demandes/index', [DemandeMaintenanceController::class, 'index'])->name('locataire.demandes.index');


    // AGENT IMMOBILIERS VOIR LES DEMANDES

    Route::get('/agent/demandes', [DemandeMaintenanceController::class, 'afficherDemandesAgent'])->name('agent.demandes');

    // mise a jour des stauts des demandes par l'agent immobilier
    Route::patch('/agent/demandes/{id}', [DemandeMaintenanceController::class, 'mettreAJourStatut'])->name('agent.demandes.update');
});


// ADMINITRATEUR DEMANDE MANTENANCE SUPERVISION
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('demandes-maintenance/grouped', [DemandeMaintenanceController::class, 'indexGrouped'])
        ->name('admin.demandes.grouped');
});



// Routes pour les agents immobiliers
Route::post('/admin/agents/toggle-status/{id}', [AgentImmobilierController::class, 'toggleStatus'])->name('admin.agents.toggleStatus');


// Routes pour les locataires
Route::prefix('locataires')->group(function () {
    Route::post('/{id}/toggle-status', [LocataireController::class, 'toggleStatus']);
});



//route administrateurs
Route::get('/admin/agents/index', [AgentImmobilierController::class, 'index'])->name('admin.agents.index');
Route::get('/admin/agents/{id}', [AgentImmobilierController::class, 'show'])->name('admin.agents.show');
Route::patch('/agents/{id}/update-status', [AgentImmobilierController::class, 'updateStatus'])->name('agents.updateStatus');




Route::prefix('admin')->middleware('auth')->group(function () {
    // Afficher les locataires par agence
    Route::get('/locataires_par_agence', [ActionAdminController::class, 'afficherLocatairesParAgence'])->name('admin.locataires_par_agence');

    // Changer le statut du locataire
    Route::post('/locataires/{id}/changer-etat', [ActionAdminController::class, 'changerEtatLocataire'])->name('admin.locataires.changer.etat');

    // Supprimer le locataire
    Route::delete('/locataires/{id}/supprimer', [ActionAdminController::class, 'supprimerLocataire'])->name('admin.locataires.supprimer');
});

// Route pour afficher le profil du locataire par l'administrateur
Route::get('admin/locataires/{locataire}/profil', [LocataireController::class, 'showProfil'])->name('admin.locataires.profil');



// route pour afficher la liste de tout les paiement par ladministrateur


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/{id}/details', [PaiementController::class, 'afficherDetailsPaiement'])->name('paiements.details');
    Route::get('/paiements/{id}/quittance', [PaiementController::class, 'telechargerQuittancePaiement'])->name('paiements.quittance');
});


//GESTIONQUITTANCE D4UN PAIEMENT SPECIFIQUE



Route::get('/admin/contrats-de-bail', [ActionAdminController::class, 'index'])->name('admin.contrats_de_bail.index');
Route::post('/admin/contrats-de-bail', [ActionAdminController::class, 'store'])->name('admin.contrats_de_bail.store');
Route::delete('/admin/contrats-de-bail/{id}', [ActionAdminController::class, 'destroy'])->name('admin.contrats_de_bail.destroy');


//  DETAIL CONTRAT POUR L4ADMIN

Route::get('/admin/contrats_de_bail/{id}', [ActionAdminController::class, 'showContractDetails'])->name('admin.contrats_de_bail.show');

// EXPOTER UN CONTRAT PAR L4AMINISTRATEUR DIFFERENT DE POUR L4AGENT
Route::get('/admin/contrats_de_bail/{id}/export_pdf', [ActionAdminController::class, 'exportContractToPDF'])->name('admin.contrats_de_bail.export_pdf');

//try
// Route::get('/info_detail_bien', function () {
//     return view('layouts.bien_detail');
// })->name('bien_detail');

// Afficher la page d'assignation
Route::get('/bien/{id}/assign-locataire', [LocataireBienController::class, 'showAssignPage'])->name('assign.locataire');

// Assigner le locataire
Route::post('/bien/{id}/assign-locataire', [LocataireBienController::class, 'assignLocataire']);

//route pour recherche dynaique assignement
Route::get('/locataires/search', [LocataireController::class, 'search'])->name('locataires.search');
//route pour desassigner locataire
Route::delete('/biens/{bien}/unassign-locataire', [LocataireBienController::class, 'unassignLocataire'])->name('unassign.locataire');

//route contrat de bail
Route::resource('/Contrat_de_bail', ContratDeBailController::class)->names('contrat');
//route article
Route::resource('/Article_contrat_bail', ArticleContratBailController::class)->names('article');


//route pour update contrat de bail
// Route::put('/contrats-de-bail/{id}/update-photo', [ContratDeBailController::class, 'updatePhoto'])->name('contrats_de_bail.update_photo');
Route::post('/save-signature', [ContratDeBailController::class, 'saveSignature'])->name('save.signature');

//
//route pour afficher les info des bien
Route::get('/biens/{bien_id}/{agent_id?}', [BienController::class, 'show'])->name('biens.show');

//export contrat bail
Route::get('/export/contrat-de-bail/{bien_id}/{agent_id?}', [ContratDeBailController::class, 'export'])->name('contrat.export');

Route::get('/payments/form', [PaiementController::class, 'showForm'])->name('payments.form');
Route::get('/paiements/callback', [PaiementController::class, 'handleCallback'])->name('payments.callback');

//gestion_periode
Route::get('/information_montant', [AgentImmobilierController::class, 'info_gestion'])->name('information_gestion');

// Historique des paiements
Route::get('/agent/paiements/historique', [PaiementController::class, 'historiqueTousLocataires'])
    ->name('agent_immo_historique');

// Route::get('profil_agent', function () {
//     return view('layouts.profil_agent');
// })->name('profil_agent');
Route::get('/profil_agent', [AgentImmobilierController::class, 'showProfiles'])->name('profil_agent');


//NOTIFICATION ROUTE
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all_notification');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});


Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');

