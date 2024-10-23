<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{  
    use HasFactory;
    protected $fillable = ['montant', 'date_paiement', 'moyen_paiement', 'statut_paiement', 'id_locataire', 'id_bien'];

    // Relation Many-to-One : Un paiement est effectué par un locataire
    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'id_locataire');
    }

    // Relation Many-to-One : Un paiement est lié à un bien
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }
}
