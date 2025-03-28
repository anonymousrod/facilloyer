<?php


namespace App\Notifications;

use App\Models\GestionPeriode;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelPaiementLoyerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $periode;
    protected $type; // 'moitié' ou 'fin'

    public function __construct(GestionPeriode $periode, $type)
    {
        $this->periode = $periode;
        $this->type = $type;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->type === 'moitié'
                ? "📢 Rappel : Vous êtes à la moitié de votre période de paiement pour le bien **{$this->periode->bien->name_bien}**.\n📌 **Votre montant restant est de :** " . number_format($this->periode->montant_restant_periode, 2) . " FCFA."
                : "📢 Attention : La fin de votre période de paiement pour le bien **{$this->periode->bien->name_bien}** approche.\n📌 **Votre montant restant est de :** " . number_format($this->periode->montant_restant_periode, 2) . " FCFA.",
            'montant_restant' => $this->periode->montant_restant_periode,
            'url' => route('locataire.paiements.historique')
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->type === 'moitié'
                ? "📢 Rappel : Vous êtes à la moitié de votre période de paiement pour le bien **{$this->periode->bien->name_bien}**.\n📌 **Votre montant restant est de :** " . number_format($this->periode->montant_restant_periode, 2) . " FCFA."
                : "📢 Attention : La fin de votre période de paiement pour le bien **{$this->periode->bien->name_bien}** approche.\n📌 **Votre montant restant est de :** " . number_format($this->periode->montant_restant_periode, 2) . " FCFA.",
            'montant_restant' => $this->periode->montant_restant_periode,
            'url' => route('locataire.paiements.historique')
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->periode->locataire->user->id);
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📢 Rappel de Paiement de Loyer')
            ->greeting("Bonjour {$this->periode->locataire->nom},")
            ->line($this->type === 'moitié'
                ? "Nous vous rappelons que vous êtes à la moitié de votre période de paiement pour le bien **{$this->periode->bien->name_bien}**."
                : "Attention : Votre période de paiement arrive à son terme pour le bien **{$this->periode->bien->name_bien}**.")
            ->line("📌 **Montant restant :** " . number_format($this->periode->montant_restant_periode, 2) . " FCFA.")
            ->action('Voir mes loyers', route('locataire.paiements.historique'))
            ->line("Merci d'utiliser notre plateforme !");
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
