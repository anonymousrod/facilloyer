<?php

namespace App\Notifications;

use App\Models\Paiement;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $paiement;

    public function __construct(Paiement $paiement)
    {
        $this->paiement = $paiement;
    }

    /**
     * Définir les canaux par lesquels la notification sera envoyée.
     */
    public function via($notifiable)
    {
        // Nous utilisons la notification en base, en temps réel (broadcast) et par email.
        return ['database', 'broadcast', 'mail'];
        // Pour le SMS, vous pourrez ajouter un canal personnalisé ou l'envoyer dans le Listener.
    }

    /**
     * Contenu de la notification pour la base de données.
     */
    public function toDatabase($notifiable)
    {
        return [
            'paiement_id' => $this->paiement->id,
            'message' => "Un paiement de " . $this->paiement->montant_paye . " € a été effectué par le locataire.",
            'url' => route('locataire.paiements.detail', $this->paiement->id)

        ];
    }

    /**
     * Contenu de la notification pour la diffusion en temps réel (Pusher).
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'paiement_id' => $this->paiement->id,
            'message' => "Un paiement de " . $this->paiement->montant_paye . " € a été effectué par un locataire.",
            'url' => route('locataire.paiements.detail', $this->paiement->id)
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->paiement->locataire->agent_immobilier->user->id);
    }

    /**
     * Notification par email.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau paiement reçu')
            ->greeting('Bonjour,')
            ->line("Un paiement de " . $this->paiement->montant_paye . " € a été effectué par un locataire.")
            // ->action('Voir le paiement', route('paiements.show', $this->paiement->id))
            ->line('Merci d\'utiliser notre plateforme.');
    }
}
