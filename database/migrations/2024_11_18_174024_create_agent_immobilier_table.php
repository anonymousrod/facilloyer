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
        Schema::create('agent_immobilier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->string('nom_agence'); // Nom de l'agence
            $table->string('nom_admin'); // Nom de l'administrateur de l'agence
            $table->string('prenom_admin'); // Prénom de l'administrateur de l'agence
            $table->string('telephone_agence'); // Téléphone de l'administrateur
            $table->integer('annee_experience'); // Années d'expérience
            $table->string('adresse_agence'); // Adresse de l'agence
            $table->string('territoire_couvert'); // Territoire couvert
            $table->integer('nombre_bien_disponible'); // Nombre de biens disponibles
            $table->string('photo_profil')->nullable();
            $table->string('carte_identite_pdf')->nullable();
            $table->float('evaluation')->nullable(); // Note de l'agent apres evaluation
            $table->string('rccm_pdf')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_immobilier');
    }
};
