<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContratsDeBail
 * 
 * @property int $id
 * @property int $bien_id
 * @property Carbon $date_debut
 * @property Carbon|null $date_fin
 * @property float $loyer_mensuel
 * @property float $depot_de_garantie
 * @property string $adresse_bien
 * @property string|null $description
 * @property bool $renouvellement_automatique
 * @property string $periode_paiement
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
	protected $table = 'contrats_de_bail';

	protected $casts = [
		'bien_id' => 'int',
		'date_debut' => 'datetime',
		'date_fin' => 'datetime',
		'loyer_mensuel' => 'float',
		'depot_de_garantie' => 'float',
		'renouvellement_automatique' => 'bool'
	];

	protected $fillable = [
		'bien_id',
		'date_debut',
		'date_fin',
		'loyer_mensuel',
		'depot_de_garantie',
		'adresse_bien',
		'description',
		'renouvellement_automatique',
		'periode_paiement',
		'penalite_retard',
		'type_bien',
		'statut_bien',
		'conditions'
	];

	public function bien()
	{
		return $this->belongsTo(Bien::class);
	}

	public function contrat_de_bail_locataires()
	{
		return $this->hasMany(ContratDeBailLocataire::class, 'contrat_de_bail_id');
	}
}
