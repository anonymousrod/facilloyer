<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class DemandeModifContratNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contrat;
    protected $user;  // L'utilisateur qui fait la demande
    protected $demandePar;

    /**
     * Créer une nouvelle instance de notification.
     */
    public function __construct($contrat, $user)
    {
        $this->contrat = $contrat;
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
            'message' => "📑 Nouvelle demande de modification de contrat reçue de la part de " . ucfirst($this->demandePar) . ".",
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
            'message' => "📑 Nouvelle demande de modification de contrat reçue de la part de " . ucfirst($this->demandePar) . ".",
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
        $nom = $this->demandePar === 'locataire'
            ? $this->contrat->bien->agent_immobilier->nom_admin
            : $this->contrat->locataire->nom;

        $adresseBien = $this->contrat->bien->adresse_bien;

        return (new MailMessage)
            ->subject('📑 Nouvelle Demande de Modification de Contrat')
            ->greeting("Bonjour $nom,")
            ->line("Une nouvelle demande de modification a été soumise pour le contrat lié au bien situé à **$adresseBien**.")
            ->action('Voir la demande', route('demandes.modification'))
            ->line('Merci d’utiliser notre plateforme.');
    }

    /**
     * Envoi du message SMS avec Twilio.
     */
    // public function toTwilio($notifiable)
    // {
    //     // Récupérer le numéro de téléphone du récepteur (le locataire ou l'agent)
    //     $phoneNumber = $this->demandePar === 'locataire'
    //         ? $this->contrat->bien->agent_immobilier->user->phone_number
    //         : $this->contrat->locataire->user->phone_number;

    //     // Message à envoyer par SMS
    //     $message = "📑 Nouvelle demande de modification de contrat reçue de la part de " . ucfirst($this->demandePar) . ". Veuillez vérifier les détails.";

    //     // Envoi du SMS via Twilio
    //     $client = new Client(config('services.twilio.sid'), config('services.twilio.auth_token'));

    //     $client->messages->create(
    //         $phoneNumber, // Le numéro de téléphone du récepteur
    //         [
    //             'from' => config('services.twilio.phone_number'), // Ton numéro Twilio
    //             'body' => $message, // Le message à envoyer
    //         ]
    //     );
    // }
}
