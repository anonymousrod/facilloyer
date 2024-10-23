<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportFinancier extends Model
{
    
    use HasFactory;
    protected $fillable = ['contenu', 'id_proprietaire'];

    // Relation Many-to-One : Un rapport est lié à un propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class, 'id_proprietaire');
    }
}
