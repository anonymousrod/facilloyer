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
        Schema::create('contrats_de_bail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bien_id');
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade')->onUpdate('restrict');

            $table->float('loyer_mensuel'); // Loyer mensuel
            $table->float('depot_de_garantie'); // Dépôt de garantie
            $table->string('adresse_bien'); // Adresse du bien
            $table->text('description')->nullable(); // Description
            $table->boolean('renouvellement_automatique')->default(false); // Renouvellement automatique
            $table->string('penalite_retard')->nullable(); // Pénalité de retard
            $table->string('type_bien'); // Type de bien
            $table->string('statut_bien'); // Statut du bien
            $table->text('conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats_de_bail');
    }
};
