<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RappelPaiement extends Model
{

    use HasFactory;
    protected $fillable = ['date_rappel', 'montant_du', 'id_locataire', 'id_bien'];

    // Relation Many-to-One : Un rappel de paiement est lié à un locataire
    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'id_locataire');
    }
}
