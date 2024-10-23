<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{ 
    use HasFactory;
    protected $fillable = ['contenu', 'type', 'id_agent', 'id_locataire'];

    // Relation Many-to-One : Une notification est envoyée par un agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'id_agent');
    }

    // Relation Many-to-One : Une notification est destinée à un locataire
    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'id_locataire');
    }
}
