<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLocataireLogin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $password;
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vos informations de connexion')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Bienvenue sur Faciloyer ! Voici vos informations de connexion :')
            ->line('**Email :** ' . $notifiable->email)
            ->line('**Mot de passe temporaire :** ' . $this->password)
            ->line('Nous vous recommandons de changer ce mot de passe dès votre première connexion.')
            ->action('Se connecter', url('/login'))
            ->line('Merci d\'utiliser notre plateforme !');
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
