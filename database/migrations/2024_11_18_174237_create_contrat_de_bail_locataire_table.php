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
        Schema::create('contrat_de_bail_locataire', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locataire_id');
            $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('contrat_de_bail_id');
            $table->foreign('contrat_de_bail_id')->references('id')->on('contrats_de_bail')->onDelete('cascade')->onUpdate('restrict');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->string('periode_paiement'); // Période de paiement
            $table->enum('statut_paiement', ['Payé', 'Partiellement payé', 'En attente'])->default('En attente'); // État du paiement pour la période
            $table->date('echeance_paiement')->nullable(); // Date d'échéance pour la période actuelle
            $table->timestamps();
            $table->softDeletes();


            // Contrainte unique pour éviter les doublons
            $table->unique(['locataire_id', 'contrat_de_bail_id']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrat_de_bail_locataire');
        Schema::table('contrat_de_bail_locataire', function (Blueprint $table) {
            $table->dropColumn(['statut_paiement', 'echeance_paiement']);
        });
    }
};
