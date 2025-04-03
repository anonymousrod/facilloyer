<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table pivot entre ContratDeBail et ArticleContratBail
        Schema::create('contrat_de_bail_article', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrat_de_bail_id'); // Référence au contrat de bail
            $table->unsignedBigInteger('article_source_id'); // Référence à l'article par défaut
            $table->string('titre_article');  // Copie du titre de l'article
            $table->text('contenu_article');  // Copie du contenu de l'article
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreign('contrat_de_bail_id')->references('id')->on('contrats_de_bail')->onDelete('cascade');
            $table->foreign('article_source_id')->references('id')->on('article_contrat_bail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrat_de_bail_article');
    }
};
