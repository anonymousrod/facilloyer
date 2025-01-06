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
 * Class Locataire
 *
 * @property int $id
 * @property int $user_id
 * @property string $nom
 * @property string $prenom
 * @property string $adresse
 * @property string $telephone
 * @property Carbon $date_naissance
 * @property string|null $photo_profil
 * @property string $genre
 * @property float $revenu_mensuel
 * @property int $nombre_personne_foyer
 * @property string $statut_matrimoniale
 * @property string $statut_professionnel
 * @property string $garant
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|ContratDeBailLocataire[] $contrat_de_bail_locataires
 * @property Collection|Bien[] $biens
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Locataire extends Model
{
    use SoftDeletes;

    protected $table = 'locataires';

    protected $casts = [
        'user_id' => 'int',
        'agent_id' => 'int',
        'date_naissance' => 'datetime',
        'revenu_mensuel' => 'float',
        'nombre_personne_foyer' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'agent_id',
        'nom',
        'prenom',
        'adresse',
        'telephone',
        'date_naissance',
        'photo_profil',
        'genre',
        'revenu_mensuel',
        'nombre_personne_foyer',
        'statut_matrimoniale',
        'statut_professionnel',
        'garant',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contrat_de_bail_locataires()
    {
        return $this->hasMany(ContratDeBailLocataire::class);
    }

    public function biens()
    {
        return $this->belongsToMany(Bien::class, 'locataire_bien')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function locataireBiens()
    {
        return $this->hasMany(LocataireBien::class, 'locataire_id');
    }

    public function agent_immobilier()
    {
        return $this->belongsTo(AgentImmobilier::class, 'agent_id');
    }

    public function demandesMaintenance()
    {
        return $this->hasMany(DemandeMaintenance::class);
    }
}
