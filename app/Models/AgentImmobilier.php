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
 * Class AgentImmobilier
 *
 * @property int $id
 * @property int $user_id
 * @property string $nom_agence
 * @property string $nom_admin
 * @property string $prenom_admin
 * @property string $telephone_agence
 * @property int $annee_experience
 * @property string $adresse_agence
 * @property string $territoire_couvert
 * @property int $nombre_bien_disponible
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Bien[] $biens
 *
 * @package App\Models
 */
class AgentImmobilier extends Model
{
    use SoftDeletes;

	protected $table = 'agent_immobilier';

	protected $casts = [
		'user_id' => 'int',
		'annee_experience' => 'int',
		'nombre_bien_disponible' => 'int'
	];

	protected $fillable = [
		'user_id',
		'nom_agence',
		'nom_admin',
		'prenom_admin',
		'telephone_agence',
		'annee_experience',
		'adresse_agence',
		'territoire_couvert',
		'nombre_bien_disponible'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function biens()
	{
		return $this->hasMany(Bien::class);
	}
}
