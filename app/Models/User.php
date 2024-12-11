<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Sanctum\HasApiTokens;

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
 */
class User extends Authenticatable //implements MustVerifyEmail  Implements MustVerifyEmail if you need email verification
{
    use SoftDeletes;
    use  HasFactory, Notifiable, SoftDeletes; //HasApiTokens,
    // Added traits required by Breeze and Sanctum if used

    protected $table = 'users';

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'id_role' => 'int',
        'email_verified_at' => 'datetime',
        'statut' => 'boolean',
        'must_change_password' => 'boolean',

    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_role',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'must_change_password',
        'statut',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Define the relationship to the `Role` model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    /**
     * Define the relationship to the `AgentImmobilier` model.
     */
    public function agent_immobiliers()
    {
        return $this->hasMany(AgentImmobilier::class);
    }

    /**
     * Define the relationship to the `Locataire` model.
     */
    public function locataires()
    {
        return $this->hasMany(Locataire::class);
    }
}
