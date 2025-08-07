<?php

namespace App\Console\Commands;

use App\Models\Abonnement;
use App\Notifications\RappelExpirationAbonnementNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RappelExpirationAbonnement extends Command
{
    protected $signature = 'rappel:abonnement';
    protected $description = 'Envoie un rappel aux utilisateurs dont l’abonnement expire dans 3 jours, 1 jour ou le jour même';

    public function handle()
    {
        $delais = [3, 1, 0]; // jours avant expiration

        foreach ($delais as $joursAvantExpiration) {
            $dateCible = Carbon::now()->addDays($joursAvantExpiration)->toDateString();

            $abonnements = Abonnement::where('status', 'actif')
                ->whereDate('date_fin', $dateCible)
                ->get();

            $this->info("🔍 [J-{$joursAvantExpiration}] Abonnements trouvés : " . $abonnements->count());

            foreach ($abonnements as $abonnement) {
                if ($abonnement->agent && $abonnement->agent->user) {
                    $abonnement->agent->user->notify(
                        new RappelExpirationAbonnementNotification($abonnement, $joursAvantExpiration)
                    );

                    $this->info("✅ Notification envoyée à : " . $abonnement->agent->user->name);
                } else {
                    $this->warn("⚠️ Pas d’utilisateur associé pour l’abonnement ID {$abonnement->id}");
                }
            }
        }

        $this->info('📢 Rappel des abonnements expirant bientôt envoyé avec succès.');
    }
}
