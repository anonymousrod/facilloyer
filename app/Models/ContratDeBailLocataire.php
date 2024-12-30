<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContratDeBailLocataire
 *
 * @property int $id
 * @property int $locataire_id
 * @property int $contrat_de_bail_id
 * @property Carbon $date_debut
 * @property Carbon|null $date_fin
 * @property float|null $complement_au_loyer
 * @property float|null $montant_restant
 * @property float|null $montant_total_periode
 * @property string $periode_paiement
 * @property string $statut_paiement
 * @property Carbon|null $echeance_paiement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property ContratsDeBail $contrats_de_bail
 * @property Locataire $locataire
 */
class ContratDeBailLocataire extends Model
{
    use SoftDeletes;

    protected $table = 'contrat_de_bail_locataire';

    protected $casts = [
        'locataire_id' => 'int',
        'contrat_de_bail_id' => 'int',
        'complement_au_loyer' => 'float',
        'montant_restant' => 'float',
        'montant_total_periode' => 'float',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'echeance_paiement' => 'date'
    ];

    protected $fillable = [
        'locataire_id',
        'contrat_de_bail_id',
        'date_debut',
        'date_fin',
        'complement_au_loyer',
        'montant_restant',
        'montant_total_periode',
        'periode_paiement',
        'statut_paiement',
        'echeance_paiement',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function contrats_de_bail()
    {
        return $this->belongsTo(ContratsDeBail::class, 'contrat_de_bail_id');
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}
