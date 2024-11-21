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
            $table->string('nom'); // Nom
            $table->string('prenom'); // Prénom
            $table->string('adresse'); // Adresse
            $table->string('telephone'); // Téléphone
            $table->date('date_naissance'); // Date de naissance
            $table->string('genre'); // Genre
            $table->float('revenu_mensuel'); // Revenu mensuel
            $table->integer('nombre_personne_foyer'); // Nombre de personnes dans le foyer
            $table->string('statut_matrimoniale'); // Statut matrimonial
            $table->string('statut_professionnel'); // Statut professionnel
            $table->string('garant'); // Garant
            $table->string('photo_profil')->nullable(); // Photo de profil
            $table->timestamps();
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
