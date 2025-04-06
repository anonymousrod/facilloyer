<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($article) {
            // Vérifier si l'article est utilisé dans des contrats
            $isUsedInContracts = DB::table('contrat_de_bail_article')
                ->where('article_source_id', $article->id)
                ->exists();

            if ($isUsedInContracts) {
                throw new \Exception("Impossible de supprimer cet article, il est utilisé dans des contrats existants.");
            }
        });
    }
}
