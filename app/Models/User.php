<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property int $id_role
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 * @property Collection|AgentImmobilier[] $agent_immobiliers
 * @property Collection|Locataire[] $locataires
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'id_role' => 'int',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'id_role',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'id_role');
	}

	public function agent_immobiliers()
	{
		return $this->hasMany(AgentImmobilier::class);
	}

	public function locataires()
	{
		return $this->hasMany(Locataire::class);
	}
}
