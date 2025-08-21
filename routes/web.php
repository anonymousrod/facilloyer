<?php

use Illuminate\Support\Facades\Route;
use Chatify\Http\Controllers\CustomMessagesController;

use App\Http\Controllers\{
    AbonnementController,
    ActionAdminController,
    AgentImmobilierController,
    ArticleContratBailController,
    BienController,
    ContratDeBailController,
    ContratModificationRequestController,
    DashboardController,
    DemandeMaintenanceController,
    ExportListePDF,
    LocataireBienController,
    LocataireController,
    NotificationController,
    PaiementController,
    PlanController,
    ProfileController
};

// =========================
// PAGE D'ACCUEIL
// =========================
Route::get('/', fn() => view('welcome'));

// =========================
// LANGUE
// =========================
Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en','es','de','fr'])) {
        session(['locale' => $lang]);
        app()->setLocale($lang);
    }
    return redirect()->back();
})->name('change.language');

// =========================
// DASHBOARD
// =========================
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

// =========================
// PROFIL
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');
});

// =========================
// LOCATAIRES
// =========================
Route::get('/locataire/{locataire}/locashow', [LocataireController::class,'showInformations'])
    ->name('locataire.locashow');

Route::get('/locataire/{locataire}/locatairebien', [LocataireBienController::class,'showlocatairebien'])
    ->name('locataire_bien');



Route::middleware('auth')->group(function () {
    Route::get('/locataire/agentinfo', [LocataireController::class,'agenceImmobiliereAssociee'])->name('locataire.agentinfo');
    Route::post('/locataires/{id}/toggle-status', [LocataireController::class,'toggleStatus']);
});

Route::resource('locataire', LocataireController::class);

// =========================
// AGENTS IMMOBILIERS
// =========================
Route::put('/agent/evaluation/{id}', [AgentImmobilierController::class,'updateEvaluation'])->name('agent.updateEvaluation');
Route::resource('/agent-immobilier', AgentImmobilierController::class)->names('agent_immobilier');

// =========================
// BIENS
// =========================
Route::middleware(['auth','check_abonnement'])->group(function () {
    Route::resource('/biens', BienController::class)->names('biens');
    Route::get('/biens/{bien_id}/{agent_id?}', [BienController::class,'show'])->name('biens.show');

    // Assignation locataire
    Route::get('/bien/{id}/assign-locataire', [LocataireBienController::class,'showAssignPage'])->name('assign.locataire');
    Route::post('/bien/{id}/assign-locataire', [LocataireBienController::class,'assignLocataire']);
    Route::delete('/biens/{bien}/unassign-locataire', [LocataireBienController::class,'unassignLocataire'])->name('unassign.locataire');
    Route::get('/locataires/search', [LocataireController::class,'search'])->name('locataires.search');

    // Export PDF
    Route::get('/export/pdf', [ExportListePDF::class,'exportPdf'])->name('export.pdf');
    Route::get('/export_biens/pdf', [ExportListePDF::class,'exportPdf_biens'])->name('export_biens.pdf');

    // Auditer paiement

    Route::get('/information_montant', [AgentImmobilierController::class, 'info_gestion'])->name('information_gestion');
});

// =========================
// PAIEMENTS
// =========================
Route::middleware('auth')->group(function () {
    // Locataire
    Route::get('/locataire/paiements/historique', [PaiementController::class,'historique'])->name('locataire.paiements.historique');
    Route::post('/locataire/paiements/store', [PaiementController::class,'store'])->name('locataire.paiements.store');
    Route::post('/locataire/paiements/create', [PaiementController::class,'create'])->name('locataire.paiements.create');
    Route::get('/locataire/paiements/{id}/quittance', [PaiementController::class,'generateQuittance'])->name('locataire.paiements.quittance');
    Route::get('/locataire/paiements/{id}/detail', [PaiementController::class,'show'])->name('locataire.paiements.detail');
    Route::get('/agent/paiements/{id}/detail', [PaiementController::class,'show'])->name('agent_historique_detail');

    // Paiement logique
    Route::get('/periodes', [PaiementController::class,'trouverPeriode'])->name('periodes.show');
    Route::get('/paiement/partiepaiement', [PaiementController::class,'partiepaiement'])->name('paiement.partiepaiement');
    Route::post('/paiement/complement', [PaiementController::class,'ajouterComplement'])->name('paiement.complement');
    Route::get('/paiement/form', [PaiementController::class,'showForm'])->name('paiement.form');
    Route::post('/paiement/kkiapay/success', [PaiementController::class,'enregistrerPaiement'])->name('paiement.kkiapay.success');

    // Agent
    Route::get('/agent/paiements/historique', [PaiementController::class,'historiqueTousLocataires'])->name('agent_immo_historique');
    Route::get('/payments/form', [PaiementController::class,'showForm'])->name('payments.form');
    Route::get('/paiements/callback', [PaiementController::class,'handleCallback'])->name('payments.callback');
});

// =========================
// DEMANDES DE MAINTENANCE
// =========================
Route::middleware('auth')->group(function () {
    // Locataire
    Route::get('/locataire/demandes/create', [DemandeMaintenanceController::class,'create'])->name('locataire.demandes.create');
    Route::post('/locataire/demandes', [DemandeMaintenanceController::class,'store'])->name('locataire.demandes.store');
    Route::get('/locataire/demandes/index', [DemandeMaintenanceController::class,'index'])->name('locataire.demandes.index');

    // Agent
    Route::get('/agent/demandes', [DemandeMaintenanceController::class,'afficherDemandesAgent'])->name('agent.demandes');
    Route::patch('/agent/demandes/{id}', [DemandeMaintenanceController::class,'mettreAJourStatut'])->name('agent.demandes.update');

    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('demandes-maintenance/grouped', [DemandeMaintenanceController::class,'indexGrouped'])->name('admin.demandes.grouped');
    });
});

// =========================
// CONTRATS DE BAIL & ARTICLES
// =========================
Route::middleware(['auth','check_abonnement'])->group(function () {
    Route::resource('/Contrat_de_bail', ContratDeBailController::class)->names('contrat');
    Route::resource('/Article_contrat_bail', ArticleContratBailController::class)->names('article');
    Route::put('/contrats/{id}/resilier', [ContratDeBailController::class,'resilier'])->name('contrats.resilier');

    // Article spécifique
    Route::get('/contrats/{contratId}/article-specifique', [ArticleContratBailController::class,'create_specifique'])->name('article.create_specifique');
    Route::post('/contrats/{contratId}/ajouter-article', [ArticleContratBailController::class,'ajouterArticleSpecifique'])->name('article.ajouterArticleSpecifique');
    Route::delete('/contrats/articles-specifiques/{article}', [ContratDeBailController::class,'supprimerArticleSpecifique'])->name('contrats.articlesSpecifiques.supprimer');
    Route::put('/contrats/articles-specifiques/{article}', [ContratDeBailController::class,'updateArticleSpecifique'])->name('contrats.articlesSpecifiques.update');

    // Modification contrat
    Route::post('/modification/demander', [ContratModificationRequestController::class,'demander'])->name('modification.demander');
    Route::put('/modification/accepter/{id}', [ContratModificationRequestController::class,'accepter'])->name('modification.accepter');
    Route::put('/modification/refuser/{id}', [ContratModificationRequestController::class,'refuser'])->name('modification.refuser');
    Route::get('/demandes-modification', [ContratModificationRequestController::class,'showDemandesModification'])->name('demandes.modification');

    // Signature & Export
    Route::post('/save-signature', [ContratDeBailController::class,'saveSignature'])->name('save.signature');
    Route::get('/export/contrat-de-bail/{bien_id}/{agent_id?}', [ContratDeBailController::class,'export'])->name('contrat.export');
});

// =========================
// ABONNEMENTS / PLANS
// =========================
Route::get('/plans-abonnement', [AbonnementController::class, 'index'])->name('plans.index');
// Route::get('/abonnement/success', [AbonnementController::class, 'success'])->name('abonnement.success');
Route::get('/plans', [PlanController::class, 'index'])->middleware('auth')->name('plans_abonnement');
Route::post('/plans/subscribe/{id}', [PlanController::class, 'subscribe'])->middleware('auth')->name('plans.subscribe');

Route::middleware(['auth'])->group(function () {
    Route::get('/mon-abonnement', [AbonnementController::class, 'current'])->name('abonnement.current');
    Route::get('/historique-abonnement', [AbonnementController::class, 'historique'])->name('abonnement.historique');
});


// =========================
// ADMIN
// =========================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Agents
    Route::get('/agents/index', [AgentImmobilierController::class,'index'])->name('agents.index');
    Route::get('/agents/{id}', [AgentImmobilierController::class,'show'])->name('agents.show');
    Route::patch('/agents/{id}/update-status', [AgentImmobilierController::class,'updateStatus'])->name('agents.updateStatus');
    Route::post('/agents/toggle-status/{id}', [AgentImmobilierController::class,'toggleStatus'])->name('agents.toggleStatus');

    // Locataires
    Route::get('/locataires_par_agence', [ActionAdminController::class,'afficherLocatairesParAgence'])->name('locataires_par_agence');
    Route::post('/locataires/{id}/changer-etat', [ActionAdminController::class,'changerEtatLocataire'])->name('locataires.changer.etat');
    Route::delete('/locataires/{id}/supprimer', [ActionAdminController::class,'supprimerLocataire'])->name('locataires.supprimer');
    Route::get('/locataires/{locataire}/profil', [LocataireController::class,'showProfil'])->name('locataires.profil');

    // Paiements
    Route::get('/paiements', [PaiementController::class,'index'])->name('paiements.index');
    Route::get('/paiements/{id}/details', [PaiementController::class,'afficherDetailsPaiement'])->name('paiements.details');
    Route::get('/paiements/{id}/quittance', [PaiementController::class,'telechargerQuittancePaiement'])->name('paiements.quittance');

    // Contrats
    Route::get('/contrats-de-bail', [ActionAdminController::class,'index'])->name('contrats_de_bail.index');
    Route::post('/contrats-de-bail', [ActionAdminController::class,'store'])->name('contrats_de_bail.store');
    Route::delete('/contrats-de-bail/{id}', [ActionAdminController::class,'destroy'])->name('contrats_de_bail.destroy');
    Route::get('/contrats_de_bail/{id}', [ActionAdminController::class,'showContractDetails'])->name('contrats_de_bail.show');
    Route::get('/contrats_de_bail/{id}/export_pdf', [ActionAdminController::class,'exportContractToPDF'])->name('contrats_de_bail.export_pdf');
});

// =========================
// NOTIFICATIONS
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class,'index'])->name('all_notification');
    Route::post('/notifications/{id}/read', [NotificationController::class,'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class,'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/fetch', [NotificationController::class,'fetch'])->name('notifications.fetch');
    Route::delete('/notifications/delete-all', [NotificationController::class,'deleteAll'])->name('notifications.delete-all');
    Route::delete('/notifications/{id}', [NotificationController::class,'deleteNotification'])->name('notifications.delete');
});

require __DIR__ . '/auth.php';

// =========================
// DOUBLONS IDENTIFIÉS (pour référence)
// =========================
// /paiement/form  et /payments/form
// LocataireController toggleStatus (2x route)
// Paiements create/store historique (plusieurs routes)
// Notifications routes multiples
// Plans / Abonnement routes multiples
Route::get('/password_change', [LocataireController::class, 'showChangePasswordForm'])->name('passwordChangeForm');
Route::post('/password_change_save', [LocataireController::class, 'changePassword'])->name('passwordChangeFormSave');

/////////////////////
Route::post('/admin/agents/toggle-status/{id}', [AgentImmobilierController::class, 'toggleStatus'])->name('admin.agents.toggleStatus');
Route::patch('/agents/{id}/update-status', [AgentImmobilierController::class, 'updateStatus'])->name('agents.updateStatus');
/////////////////
Route::get('/profil_agent', [AgentImmobilierController::class, 'showProfiles'])->name('profil_agent');
//////////////////
Route::delete('/contrats/{contratId}/articles/{articleId}', [ContratDeBailController::class, 'detachArticle'])
    ->name('contrats.detachArticle');
////////////////////////
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
});

Route::get('/info_detail_bien', function () {
    return view('layouts.bien_detail');
})->name('bien_detail');



