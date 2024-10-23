<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{   use HasFactory;
    protected $fillable = ['nom', 'email', 'telephone', 'adresse', 'id_bien'];

    // Relation Many-to-One : Un locataire loue un bien
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }

    // Relation One-to-Many : Un locataire effectue plusieurs paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_locataire');
    }
}

