<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionPeriodeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gestion_periode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrat_de_bail_id');
            $table->unsignedBigInteger('locataire_id'); 
            $table->unsignedBigInteger('bien_id'); 
            $table->date('date_debut_periode');
            $table->date('date_fin_periode');
            $table->float('montant_total_periode', 10, 2);
            $table->float('complement_periode', 10, 2)->nullable();
            $table->float('montant_restant_periode', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreign('contrat_de_bail_id')
                ->references('id')
                ->on('contrats_de_bail')
                ->onDelete('cascade');

            $table->foreign('locataire_id')
                ->references('id')
                ->on('locataires') // Assurez-vous que le nom de la table des locataires est correct
                ->onDelete('cascade');

            $table->foreign('bien_id')
                ->references('id')
                ->on('biens') // Assurez-vous que le nom de la table des biens est correct
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_periode');
    }
}