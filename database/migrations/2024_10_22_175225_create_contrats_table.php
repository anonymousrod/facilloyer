<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->bigIncrements('id_contrat'); // Clé primaire auto-incrémentée
            $table->date('date_debut');
            $table->date('date_fin');
            $table->float('montant_loyer');
            $table->text('conditions')->nullable();
            
            // Clé étrangère vers locataires
            $table->unsignedBigInteger('id_locataire');
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            
            // Clé étrangère vers biens
            $table->unsignedBigInteger('id_bien');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrats');
    }
};
