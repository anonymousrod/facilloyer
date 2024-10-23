<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Bien extends Model
{   
    use HasFactory;
    protected $fillable = ['adresse', 'type_bien', 'statut', 'id_agent'];

    // Relation Many-to-One : Un bien appartient à un agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'id_agent');
    }

    // Relation Many-to-One : Un bien est loué par un locataire
    public function locataire()
    {
        return $this->hasOne(Locataire::class, 'id_bien');
    }

    // Relation Many-to-One : Un bien appartient à un propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class, 'id_proprietaire');
    }
}
