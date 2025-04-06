<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContratModificationRequest extends Model
{
    use HasFactory;

    protected $table = 'contrat_modification_requests';

    protected $fillable = [
        'contrat_de_bail_id',
        'demande_par',
        'motif',
        'statut',
    ];

    // Relation avec le contrat de bail
    public function contrat()
    {
        return $this->belongsTo(ContratsDeBail::class, 'contrat_de_bail_id');
    }
}



