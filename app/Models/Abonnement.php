<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abonnement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abonnements';
    protected $dates = ['date_debut', 'date_fin'];

    protected $fillable = [
        'agent_id',
        'plan_id',
        'transaction_id',
        'date_debut',
        'date_fin',
        'status'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function agent()
    {
        return $this->belongsTo(AgentImmobilier::class, 'agent_id');
    }
}
