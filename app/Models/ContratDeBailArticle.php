<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratDeBailArticle extends Model
{
    use HasFactory;

    protected $table = 'contrat_de_bail_article'; // Le nom de la table si différent du nom du modèle

    protected $fillable = [
        'contrat_de_bail_id',
        'article_source_id',
        'titre_article',
        'contenu_article',
    ];

    public function contrat()
    {
        return $this->belongsTo(ContratsDeBail::class, 'contrat_de_bail_id');
    }

    public function source()
    {
        return $this->belongsTo(ArticleContratBail::class, 'article_source_id');
    }
}
