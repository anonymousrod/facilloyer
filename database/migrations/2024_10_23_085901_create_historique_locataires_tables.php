<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historiques_locataires', function (Blueprint $table) {
            $table->bigIncrements('id_historique');
            $table->unsignedBigInteger('id_locataire');
            $table->unsignedBigInteger('id_bien');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->text('etat_final')->nullable(); // État du bien à la fin du bail

            // Clés étrangères
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historiques_locataires');
    }
};
