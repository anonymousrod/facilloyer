<?php

namespace App\Notifications;

use App\Models\DemandeMaintenance;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeMaintenanceNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $demande;
    /**
     * Create a new notification instance.
     */
    public function __construct(DemandeMaintenance $demande)
    {
        $this->demande = $demande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'demande_id' => $this->demande->id,
            'message' => "Vous avez reçu une nouvelle demande de maintenance ",
            'url' => route('agent.demandes')
        ];
    }

    /**
     * Contenu de la notification pour la diffusion en temps réel (Pusher).
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'demande_id' => $this->demande->id,
            'message' => "📢 Nouvelle demande de maintenance pour le bien situé à {$this->demande->bien->adresse_bien}.",
            'url' => route('agent.demandes')
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->demande->locataire->agent_immobilier->user->id);
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🔧 Nouvelle Demande de Maintenance')
            ->greeting("Bonjour {$this->demande->locataire->agent_immobilier->nom_admin} {$this->demande->locataire->agent_immobilier->prenom_admin},")
            ->line("Une nouvelle demande de maintenance a été soumise pour le bien situé à **{$this->demande->bien->adresse_bien}**.")
            ->line("📌 **Description :** {$this->demande->description}")
            ->line("⏳ **Statut :** En attente de traitement")
            ->action('Voir la demande', route('agent.demandes'))
            ->line("Merci d'utiliser notre plateforme !");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
