<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paiement;
use App\Notifications\PaymentReceivedNotification;

class CheckNewPayments extends Command
{
    protected $signature = 'payments:check-new';
    protected $description = 'Vérifie les nouveaux paiements et envoie des notifications à l\'agent immobilier';

    public function handle()
    {
        // Récupère tous les paiements non notifiés
        $newPayments = Paiement::where('notified', false)->get();

        if ($newPayments->isEmpty()) {
            $this->info('Aucun nouveau paiement à notifier.');
            return 0;
        }

        foreach ($newPayments as $payment) {
            // Supposons que le modèle Paiement possède une relation vers le locataire
            // et que le locataire possède une relation vers l'agent immobilier.
            $locataire = $payment->locataire;
            if ($locataire && $locataire->agent_immobilier) {
                $agent = $locataire->agent_immobilier;

                // Envoyer la notification via les canaux définis dans PaymentReceivedNotification
                $agent->user->notify(new PaymentReceivedNotification($payment));

                // Envoyer la notification par SMS (exemple avec Twilio)
                $this->sendSmsNotification($agent->telephone_agence, "Nouveau paiement de " . $payment->montant_paye . "€ reçu.");
            }

            // Marquer le paiement comme notifié
            $payment->notified = true;
            $payment->save();

            $this->info("Paiement #{$payment->id} notifié.");
        }

        return 0;
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
}
