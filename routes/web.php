<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentImmobilierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocataireController;

Route::get('/', function () {
    return view('welcome');
});

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

// route concernant agent immobilier

// Route::get('/agent-immobilier/create', [AgentImmobilierController::class, 'create'])->name('agence_info.create');
// Route::post('/agent-immobilier/store', [AgentImmobilierController::class, 'store'])->name('agence_info.store');
// Route::post('/agent-immobilier/update', [AgentImmobilierController::class, 'update'])->name('agence_info.update');
Route::resource('/agent-immobilier', AgentImmobilierController::class)->names('agent_immobilier');
Route::resource('/locataire', LocataireController::class)->names('locataire');
//route pour le changement de mot de passe pour new locataire
Route::get('/password_change', [LocataireController::class, 'showChangePasswordForm'])->name('passwordChangeForm');
Route::post('/password_change_save', [LocataireController::class, 'changePassword'])->name('passwordChangeFormSave');
//route pour changer le statut du locataire par l'agent immobilier
Route::post('/locataires/{id}/toggle-status', [LocataireController::class, 'toggleStatus']);


// Route::middleware(['auth'])->group(function () {
Route::get('/locataire/edit', [LocataireController::class, 'edit'])->name('locataire.edit');
Route::patch('/locataire/{id}', [LocataireController::class, 'update'])->name('locataire.update');
// });





// try

Route::get('/liste_locataire', function(){
     return view('layouts.liste_locataire');
 })->name('liste_locataire');



