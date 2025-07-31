<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonnementController;
Route::post('/abonnement/success', [AbonnementController::class, 'success'])->name('api.abonnement.success');
// Dans routes/api.php
Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});
