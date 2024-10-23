<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'telephone', 'adresse'];

    // Relation One-to-Many : Un agent possède plusieurs biens
    public function biens()
    {
        return $this->hasMany(Bien::class, 'id_agent');
    }
}
