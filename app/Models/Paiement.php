<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Paiement
 *
 * @property int $id
 * @property int $locataire_id
 * @property int $bien_id
 * @property float $montant
 * @property Carbon $date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Bien $bien
 * @property Locataire $locataire
 */
class Paiement extends Model
{
    use SoftDeletes;

    protected $table = 'paiements';

    protected $casts = [
        'locataire_id' => 'int',
        'bien_id' => 'int',
        'montant' => 'float',
        'date' => 'date'
    ];

    protected $fillable = [
        'locataire_id',
        'bien_id',
        'montant',
        'date',
        'status',
    ];

    /**
     * Relation avec le modèle Bien.
     */
    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    /**
     * Relation avec le modèle Locataire.
     */
    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}
