<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleContratBail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'article_contrat_bail';

    protected $fillable = [
        'agent_immobilier_id',
        'titre_article',
        'contenu_article',
    ];

    /**
     * Relation avec l'Agent Immobilier.
     */
    public function agent_immobiliers()
    {
        return $this->belongsTo(AgentImmobilier::class);
    }
}
