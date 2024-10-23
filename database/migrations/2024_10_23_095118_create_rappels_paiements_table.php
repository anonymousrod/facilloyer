<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rappels_paiements', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->unsignedBigInteger('id_locataire');
            $table->unsignedBigInteger('id_agent');
            $table->unsignedBigInteger('id_bien');
            $table->date('date_rappel');
            $table->boolean('statut_rappel')->default(false); // Statut du rappel (envoyé ou non)
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            $table->foreign('id_agent')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rappels_paiements');
    }
};
