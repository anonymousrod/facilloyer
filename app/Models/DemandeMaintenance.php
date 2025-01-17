<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMaintenance extends Model
{
    use HasFactory;

    // Nom de la table
    protected $table = 'demandes_maintenance';

    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'locataire_id',
        'bien_id',
        'description',
        'statut'
    ];

    /**
     * Relation avec le locataire (appartenant à)
     */
    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }

   

    /**
     * Relation avec le bien (appartenant à)
     */
    
    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }


    
}
