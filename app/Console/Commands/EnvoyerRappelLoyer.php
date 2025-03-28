<?php
//UTILE POUR LES TESTE
// $aujourdHui = Carbon::createFromFormat('Y-m-d', '2025-03-27');
// $this->info("Début période : {$dateDebut->toDateString()}");
// $this->info("Fin période : {$dateFin->toDateString()}");
// $this->info("Milieu période : {$moitiePeriode->toDateString()}");
// $this->info("Rappel avant fin : {$rappelAvantFin->toDateString()}");
// $this->info("Aujourd'hui : {$aujourdHui->toDateString()}");

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GestionPeriode;
use App\Models\Locataire;
use App\Notifications\RappelPaiementLoyerNotification;
use Carbon\Carbon;

class EnvoyerRappelLoyer extends Command
{
    protected $signature = 'rappel:loyer';
    protected $description = 'Envoyer un rappel de paiement de loyer aux locataires à mi-période et quelques jours avant la fin de la période';

    public function handle()
    {
        // Récupérer la dernière période enregistrée pour chaque locataire
        $latestPeriods = GestionPeriode::whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('gestion_periode')
                ->groupBy('locataire_id', 'contrat_de_bail_id');
        })->get();
        $this->info('Nombre de périodes récupérées : ' . $latestPeriods->count());


        foreach ($latestPeriods as $periode) {
            $dateDebut = Carbon::parse($periode->date_debut_periode);
            $dateFin = Carbon::parse($periode->date_fin_periode);
            $moitiePeriode = $dateDebut->copy()->addDays($dateDebut->diffInDays($dateFin) / 2);
            $rappelAvantFin = $dateFin->copy()->subDays(3); // 3 jours avant la fin

            // $aujourdHui = Carbon::now();
            $aujourdHui = Carbon::createFromFormat('Y-m-d', '2025-03-27');

            // Vérifier si on est à la moitié de la période ou 3 jours avant la fin
            if ($aujourdHui->isSameDay($moitiePeriode) || $aujourdHui->isSameDay($rappelAvantFin)) {
                // Déterminer le type de rappel
                $type = $aujourdHui->isSameDay($moitiePeriode) ? 'moitié' : 'fin';

                // Récupérer le locataire
                $locataire = Locataire::find($periode->locataire_id);

                if ($locataire) {
                    // Envoyer la notification avec les deux paramètres attendus
                    $locataire->user->notify(new RappelPaiementLoyerNotification($periode, $type));

                    // Personnalisation du message SMS
                    $message = $this->getSmsMessage($periode, $type);

                    // Envoyer la notification par SMS (exemple avec Twilio)
                    $this->sendSmsNotification($locataire->telephone, $message);
                    $this->info("Notification envoyée à {$locataire->nom} ({$locataire->email}) pour le rappel de type {$type}.");
                } else {
                    $this->info('pb aujourdhuit.');
                }
            } else {
                $this->info('probleme if');
            }
        }

        $this->info('Commande rappel:loyer exécutée avec succès.');
    }

    /**
     * Envoie une notification par SMS via Twilio.
     */
    private function sendSmsNotification($phone, $message)
    {
        // Assurez-vous d'avoir installé le package Twilio via Composer
        // et configuré les variables d'environnement TWILIO_SID, TWILIO_AUTH_TOKEN, TWILIO_PHONE_NUMBER.
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create($phone, [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message
            ]);
            $this->info("SMS envoyé à {$phone}");
        } catch (\Exception $e) {
            $this->error("Erreur lors de l'envoi du SMS : " . $e->getMessage());
        }
    }

    /**
     * Génère le message SMS personnalisé en fonction du type de rappel.
     */
    private function getSmsMessage($periode, $type)
    {
        // Message basé sur le type
        if ($type === 'moitié') {
            return "📢 Rappel : Vous êtes à la moitié de votre période de paiement pour le bien **{$periode->bien->name_bien}**.\n📌 Montant restant : " . number_format($periode->montant_restant_periode, 2) . " FCFA.";
        } else {
            return "📢 Attention : La fin de votre période de paiement pour le bien **{$periode->bien->name_bien}** approche.\n📌 Montant restant : " . number_format($periode->montant_restant_periode, 2) . " FCFA.";
        }
    }
}
