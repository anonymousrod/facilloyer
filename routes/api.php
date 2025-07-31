<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonnementController;
Route::post('/abonnement/success', [AbonnementController::class, 'success'])->name('api.abonnement.success');

