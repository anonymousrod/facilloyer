<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMaintenance extends Model
{
    use HasFactory;
   
        protected $table = 'demandes_maintenance'; // Nom de la table
        protected $fillable = ['locataire_id', 'agent_id', 'libelle', 'description', 'statut'];
    
    

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }
    
    public function agentImmobilier()
    {
        return $this->belongsTo(AgentImmobilier::class, 'agent_immobilier_id');
    }
    
}
