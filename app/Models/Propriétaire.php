<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Proprietaire extends Model
{  
    use HasFactory;
    protected $fillable = ['nom', 'email', 'telephone'];

    // Relation One-to-Many : Un propriétaire possède plusieurs biens
    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_proprietaire');
    }
}
