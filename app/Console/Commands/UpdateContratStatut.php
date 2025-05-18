<?php

namespace App\Console\Commands;

use App\Models\ContratsDeBail;
use App\Models\LocataireBien;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateContratStatut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contrat:update-statut';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("👀 Contrat:update-statut lancé !");

        $contrats = ContratsDeBail::where('statut_contrat', 'Actif')
            ->whereDate('date_fin', '<=', Carbon::now())
            ->get();

        foreach ($contrats as $contrat) {
            $contrat->statut_contrat = 'termine';
            $contrat->save();

            // Suppression du lien dans locataire_bien
            $locataireBien = LocataireBien::where('bien_id', $contrat->bien->id)->first();
            if ($locataireBien) {
                $locataireBien->delete();
                $this->info("Contrat ID {$contrat->id} terminé. Locataire désassigné du bien ID {$contrat->bien->id}.");
            } else {
                $this->info("Contrat ID {$contrat->id} terminé. Aucun locataire lié trouvé pour bien ID {$contrat->bien->id}.");
            }
        }

        $this->info('Mise à jour des contrats terminée.');
    }
}
