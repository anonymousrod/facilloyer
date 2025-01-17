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
    use SoftDeletes;

    protected $table = 'biens';

    protected $casts = [
        'agent_immobilier_id' => 'int',
        'nombre_de_piece' => 'int',
        'nombre_de_salon' => 'int',
        'nombre_de_cuisine' => 'int',
        'nbr_chambres' => 'int',
        'nbr_salles_de_bain' => 'int',
        'superficie' => 'float',
        'annee_construction' => 'int',
        'loyer_mensuel' => 'float'
    ];

    protected $fillable = [
        'agent_immobilier_id',
        'name_bien',
        'name_proprietaire',
        'proprietaire_numéro',
        'adresse_bien',
        'type_bien',
        'nombre_de_piece',
        'nombre_de_salon',
        'nombre_de_cuisine',
        'nbr_chambres',
        'nbr_salles_de_bain',
        'superficie',
        // 'annee_construction',
        'description',
        'loyer_mensuel',
        'photo_bien',
        'photo2_bien',
        'photo3_bien',
        'statut_bien',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function agent_immobilier()
    {
        return $this->belongsTo(AgentImmobilier::class);
    }

    public function contrats_de_bail()
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

    // Définition de la relation avec les demandes de maintenance
    public function demandesMaintenance()
    {
        return $this->hasMany(DemandeMaintenance::class);
    }
}
