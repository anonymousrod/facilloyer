<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'locataire_id',
        'notified',
        'bien_id',
        'montant_paye',
        'date_paiement',
        'statut_paiement',
        'mode_paiement',
        'reference_paiement',
        'description',
    ];

    protected $casts = [
        'montant' => 'float',
    ];
    protected $dates = [
        'deleted_at'
    ]; // Ajoutez cette ligne pour que 'deleted_at' soit traité comme une date


    /**
     * Relation avec le modèle Bien.
     */
    public function bien()
    {
        return $this->belongsTo(Bien::class)->withDefault([
            'name_bien' => 'Bien inconnu',
            'agent_immobilier' => null,
        ]);
    }

    /**
     * Relation avec le modèle Locataire.
     */
    public function locataire()
    {
        return $this->belongsTo(Locataire::class)->withDefault([
            'nom' => 'Locataire inconnu', // Valeur par défaut si aucune donnée n'est trouvée
            'prenom' => 'Inconnu',
        ]);
    }



}
