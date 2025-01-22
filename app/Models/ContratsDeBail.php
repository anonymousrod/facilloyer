<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContratsDeBail
 *
 * @property int $id
 * @property int $bien_id

 * @property float $loyer_mensuel
 * @property float $depot_de_garantie
 * @property string $adresse_bien
 * @property string|null $description
 * @property bool $renouvellement_automatique
 * @property string|null $penalite_retard
 * @property string $type_bien
 * @property string $statut_bien
 * @property string|null $conditions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Bien $bien
 * @property Collection|ContratDeBailLocataire[] $contrat_de_bail_locataires
 *
 * @package App\Models
 */
class ContratsDeBail extends Model
{
    use SoftDeletes;

    protected $table = 'contrats_de_bail';

    protected $casts = [
        'bien_id' => 'int',
        'locataire_id' => 'int',
        'montant_total_frequence' => 'float',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'caution' => 'float',
        'caution_eau' => 'float',
        'caution_electricite' => 'float',
    ];

    protected $fillable = [
        //new
        'locataire_id',
        'date_debut',// c'est cette ligne on veux utiliseé dans la fonction
        'date_fin',
        'renouvellement_automatique',
        'montant_total_frequence',
        'frequence_paiement',
        'penalite_retard',
        'mode_paiement',
        'statut_contrat',
        //old
        'bien_id',
        'reference',
        'caution',
        'caution_eau',
        'caution_electricite',

        'lieu_signature',
        'date_signature',
        'signature_agent_immobilier',
        'signature_locataire',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }

    public function periodes()
{
    return $this->hasMany(GestionPeriode::class, 'contrat_de_bail_id');
}

}
