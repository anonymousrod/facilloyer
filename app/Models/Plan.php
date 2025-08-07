<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
        use HasFactory, SoftDeletes;

    protected $table = 'plans';

    protected $fillable = [
        'nom', 'prix', 'duree', 'description'
    ];

    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
}
