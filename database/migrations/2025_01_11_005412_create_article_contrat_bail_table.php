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
        Schema::create('article_contrat_bail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_immobilier_id');
            $table->foreign('agent_immobilier_id')->references('id')->on('agent_immobilier')->onDelete('cascade')->onUpdate('restrict');
            $table->string('titre_article');
            $table->text('contenu_article');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_contrat_bail');
    }
};
