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
        Schema::create('locataires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('agent_immobilier')->onDelete('cascade')->onUpdate('restrict');
            $table->string('nom')->nullable(); // Nom
            $table->string('prenom')->nullable(); // Prénom
            $table->string('adresse')->nullable(); // Adresse
            $table->string('telephone')->nullable(); // Téléphone
            $table->date('date_naissance')->nullable(); // Date de naissance
            $table->string('genre')->nullable(); // Genre
            $table->float('revenu_mensuel')->nullable(); // Revenu mensuel
            $table->integer('nombre_personne_foyer')->nullable(); // Nombre de personnes dans le foyer
            $table->string('statut_matrimoniale')->nullable(); // Statut matrimonial
            $table->string('statut_professionnel')->nullable(); // Statut professionnel
            $table->string('garant')->nullable(); // Garant
            $table->string('photo_profil')->nullable(); // Photo de profil
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locataires');
    }
};
