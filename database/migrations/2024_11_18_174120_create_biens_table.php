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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_immobilier_id');
            $table->foreign('agent_immobilier_id')->references('id')->on('agent_immobilier')->onDelete('cascade')->onUpdate('restrict');

            $table->string('name_proprietaire');
            $table->string('proprietaire_numéro');
            $table->string('name_bien')->nullable();
            $table->string('adresse_bien');
            $table->string('type_bien');
            $table->integer('nombre_de_salon'); // Nombre de salon
            $table->integer('nombre_de_cuisine'); // Nombre de cuisine
            $table->integer('nombre_de_piece'); // Nombre de pièces
            $table->integer('nbr_chambres'); // Nombre de chambres
            $table->integer('nbr_salles_de_bain'); // Nombre de salles de bain
            $table->float('superficie'); // Superficie
            // $table->integer('annee_construction'); // Année de construction
            $table->text('description')->nullable(); // Description
            $table->float('loyer_mensuel'); // Loyer mensuel
            $table->string('statut_bien'); // Disponible, loué, etc.
            $table->string('photo_bien')->nullable();
            $table->string('photo2_bien')->nullable();
            $table->string('photo3_bien')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
