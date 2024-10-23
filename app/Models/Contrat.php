<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model

{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'montant_loyer', 'conditions', 'id_locataire', 'id_bien'];

    // Relation Many-to-One : Un contrat est lié à un locataire
    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'id_locataire');
    }

    // Relation Many-to-One : Un contrat est lié à un bien
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }
}
