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
            $table->string('adresse_bien');
            $table->string('type_bien');
            $table->integer('nombre_de_piece'); // Nombre de pièces
            $table->float('superficie'); // Superficie
            $table->integer('annee_construction'); // Année de construction
            $table->text('description')->nullable(); // Description

            $table->float('loyer_mensuel'); // Loyer mensuel
            $table->string('statut_bien'); // Disponible, loué, etc.
            $table->timestamps();
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
