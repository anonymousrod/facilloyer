<?php

namespace App\Console\Commands;

use App\Models\Abonnement;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // <-- Ajoute cette ligne


class UpdateAbonnements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abonnements:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour le statut des abonnements expirés chaque seconde';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    $abonnementsExpirés = Abonnement::where('date_fin', '<=', Carbon::now())
        ->where('status', 'actif')
        ->get();

    Log::info("Nombre d'abonnements expirés : " . $abonnementsExpirés->count());

    foreach ($abonnementsExpirés as $abonnement) {
        $abonnement->update(['status' => 'expiré']);
        Log::info("Abonnement ID {$abonnement->id} mis à jour.");
    }

    $this->info('Statuts des abonnements expirés mis à jour avec succès.');
    }
}
