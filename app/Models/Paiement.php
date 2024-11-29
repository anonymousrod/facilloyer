<?php

/**
 * Created by Reliese Model.
 */

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
 * @property string $statut
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Bien $bien
 * @property Locataire $locataire
 *
 * @package App\Models
 */
class Paiement extends Model
{
    use SoftDeletes;

    protected $table = 'paiements';

    protected $casts = [
        'locataire_id' => 'int',
        'bien_id' => 'int',
        'montant' => 'float',
        'date' => 'datetime'
    ];

    protected $fillable = [
        'locataire_id',
        'bien_id',
        'montant',
        'date',
        'mode_paiement',
        'statut',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Méthode pour mettre à jour le statut du paiement
    public function updateStatus()
    {
        $contrat = $this->contratDeBailLocataire; // Récupérer le contrat de bail associé
        $dateLimite = Carbon::parse($contrat->date_debut)->addMonths($contrat->periode_paiement); // Calcul de la date limite de paiement

        if ($this->date_paiement <= $dateLimite) {
            $this->status = 'Payé';
        } elseif ($this->date_paiement > $dateLimite) {
            $this->status = 'Retard';
        } else {
            $this->status = 'En attente';
        }

        $this->save(); // Sauvegarde des modifications
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
}
