<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentImmobilierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportListePDF;
use App\Http\Controllers\LocataireController;

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
Route::resource('/locataire', LocataireController::class)->names('locataire');
//route pour le changement de mot de passe pour new locataire
Route::get('/password_change', [LocataireController::class, 'showChangePasswordForm'])->name('passwordChangeForm');
Route::post('/password_change_save', [LocataireController::class, 'changePassword'])->name('passwordChangeFormSave');
//route pour changer le statut du locataire par l'agent immobilier
Route::post('/locataires/{id}/toggle-status', [LocataireController::class, 'toggleStatus']);

//Route pour l'exportation de la liste des locataire en pdf

Route::get('/export/pdf', [ExportListePDF::class, 'exportPdf'])->name('export.pdf');





