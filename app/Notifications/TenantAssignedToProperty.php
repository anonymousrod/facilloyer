<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Bien;
use App\Models\Locataire;

class TenantAssignedToProperty extends Notification implements ShouldQueue
{
    use Queueable;

    public $bien;
    public $locataire;

    public function __construct(Bien $bien, Locataire $locataire)
    {
        $this->bien = $bien;
        $this->locataire = $locataire;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'bien_id' => $this->bien->id,
            'message' => "📢 Un bien au nom de  {$this->bien->name_bien} vous a été attribué.",
            'url' => route('biens.show', $this->bien)
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'bien_id' => $this->bien->id,
            'message' => "📢 Un bien au nom de  {$this->bien->name_bien} vous a été attribué.",
            'url' => route('biens.show', $this->bien)
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.Models.User.' . $this->locataire->user->id);
    }
}
