<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bien
 * 
 * @property int $id
 * @property int $agent_immobilier_id
 * @property string $adresse_bien
 * @property string $type_bien
 * @property int $nombre_de_piece
 * @property float $superficie
 * @property int $annee_construction
 * @property string|null $description
 * @property float $loyer_mensuel
 * @property string $statut_bien
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property AgentImmobilier $agent_immobilier
 * @property Collection|ContratsDeBail[] $contrats_de_bails
 * @property Collection|Locataire[] $locataires
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Bien extends Model
{
	protected $table = 'biens';

	protected $casts = [
		'agent_immobilier_id' => 'int',
		'nombre_de_piece' => 'int',
		'superficie' => 'float',
		'annee_construction' => 'int',
		'loyer_mensuel' => 'float'
	];

	protected $fillable = [
		'agent_immobilier_id',
		'adresse_bien',
		'type_bien',
		'nombre_de_piece',
		'superficie',
		'annee_construction',
		'description',
		'loyer_mensuel',
		'statut_bien'
	];

	public function agent_immobilier()
	{
		return $this->belongsTo(AgentImmobilier::class);
	}

	public function contrats_de_bails()
	{
		return $this->hasMany(ContratsDeBail::class);
	}

	public function locataires()
	{
		return $this->belongsToMany(Locataire::class, 'locataire_bien')
					->withPivot('id')
					->withTimestamps();
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
