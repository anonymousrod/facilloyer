<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class DemandeModifContratDecisionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contrat;
    protected $decision;
    protected $user;
    protected $demandePar;


    /**
     * Créer une nouvelle instance de la notification.
     */
    public function __construct($contrat, $decision, $user)
    {
        $this->contrat = $contrat;
        $this->decision = $decision;
        $this->user = $user;
        $this->demandePar = strtolower($user->role->libelle); // Récupérer le rôle de l'utilisateur

    }

    /**
     * Détermine les canaux de notification.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Représentation de la notification dans la base de données.
     */
    public function toDatabase($notifiable)
    {
        return [
            'contrat_id' => $this->contrat->id,
            'message' => "📑 La demande de modification du contrat a été {$this->decision} par {$this->user->role->libelle}.",
            'url' => route('demandes.modification'),
        ];
    }

    /**
     * Représentation de la notification en broadcast (temps réel).
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'contrat_id' => $this->contrat->id,
            'message' => "📑 La demande de modification du contrat a été {$this->decision} par {$this->user->role->libelle}.",
            'url' => route('demandes.modification'),
        ]);
    }

    /**
     * Détermine la chaîne de diffusion privée (broadcast).
     */
    public function broadcastOn()
    {
        $userToNotify = $this->demandePar === 'locataire'
        ? $this->contrat->bien->agent_immobilier->user
        : $this->contrat->locataire->user;
        return new PrivateChannel('App.Models.User.' . $userToNotify->id);
    }

    /**
     * Notification par mail.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("📑 Demande de modification de contrat - Décision")
            ->greeting("Bonjour,")
            ->line("La demande de modification de contrat pour le bien situé à **{$this->contrat->bien->adresse_bien}** a été {$this->decision} par {$this->user->role->libelle}.")
            ->action('Voir la demande', route('demandes.modification'))
            ->line('Merci d’utiliser notre plateforme.');
    }
}
