<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionPeriode extends Model
{
    use SoftDeletes;

    protected $table = 'gestion_periode';

    protected $fillable = [
        'contrat_de_bail_id',
        'locataire_id',
        'bien_id',
        'date_debut_periode',
        'date_fin_periode',
        'montant_total_periode',
        'complement_periode',
        'montant_restant_periode',
    ];

    /**
     * Relation avec le contrat de bail.
     */
    public function contratDeBail()
    {
        return $this->belongsTo(ContratsDeBail::class, 'contrat_de_bail_id');
    }

    /**
     * Relation avec le locataire.
     */
    public function locataire()
    {
        return $this->belongsTo(Locataire::class, 'locataire_id'); 
    }

    /**
     * Relation avec le bien.
     */
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id'); 
    }
}