<?php

/**
 * Created by Reliese Model.
 */

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
 * @property string $periode_paiement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ContratsDeBail $contrats_de_bail
 * @property Locataire $locataire
 *
 * @package App\Models
 */
class ContratDeBailLocataire extends Model
{
    use SoftDeletes;

    protected $table = 'contrat_de_bail_locataire';

    protected $casts = [
        'locataire_id' => 'int',
        'contrat_de_bail_id' => 'int'
    ];

    protected $fillable = [
        'locataire_id',
        'contrat_de_bail_id',
        'bien_id',
        'date_debut',
        'periode_paiement',
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
