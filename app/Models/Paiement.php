<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Paiement
 *
 * @property int $id
 * @property int $locataire_id
 * @property int $bien_id
 * @property float $montant_paye
 * @property float $montant_restant
 * @property float $montant_total_frequence
 * @property string $statut_paiement
 * @property Carbon $date_debut_frequence
 * @property Carbon $date_fin_frequence
 * @property string $frequence_paiement
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Bien $bien
 * @property Locataire $locataire
 */
class Paiement extends Model
{
    use SoftDeletes;

    protected $table = 'paiements';

    protected $casts = [
        'locataire_id' => 'int',
        'bien_id' => 'int',
        'montant_paye' => 'float',
        'montant_restant' => 'float',
        'montant_total_frequence' => 'float',
        'date_debut_frequence' => 'date',
        'date_fin_frequence' => 'date',
    ];

    protected $fillable = [
        'locataire_id',
        'bien_id',
        'montant_paye',
        'montant_restant',
        'montant_total_frequence',
        'statut_paiement',
        'date_debut_frequence',
        'date_fin_frequence',
        'frequence_paiement',
        'description'
        
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
