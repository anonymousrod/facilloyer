<?php

namespace App\Notifications;

use App\Models\Abonnement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelExpirationAbonnementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $abonnement;
    protected $joursAvant;

    public function __construct(Abonnement $abonnement, $joursAvant)
    {
        $this->abonnement = $abonnement;
        $this->joursAvant = $joursAvant;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        $message = $this->getMessage();

        return [
            'message' => $message,
            'date_fin' => $this->abonnement->date_fin,
            'plan' => $this->abonnement->plan->nom,
            'url' => route('plans_abonnement')
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function toMail($notifiable)
    {
        $message = $this->getMessage();

        return (new MailMessage)
            ->subject('📢 Rappel expiration abonnement')
            ->greeting("Bonjour {$notifiable->name},")
            ->line($message)
            ->action('Renouveler maintenant', route('plans_abonnement'))
            ->line("Merci d'utiliser notre plateforme !");
    }

    private function getMessage()
    {
        if ($this->joursAvant === 0) {
            return "⚠️ Votre abonnement **{$this->abonnement->plan->nom}** expire aujourd'hui.";
        } elseif ($this->joursAvant === 1) {
            return "⏳ Votre abonnement **{$this->abonnement->plan->nom}** expire demain.";
        } else {
            return "🔔 Votre abonnement **{$this->abonnement->plan->nom}** expire dans {$this->joursAvant} jours.";
        }
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
