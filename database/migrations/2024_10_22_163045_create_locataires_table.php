<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Création de la table 'locataires'
        Schema::create('locataires', function (Blueprint $table) {
            $table->bigIncrements('id_locataire'); // Clé primaire auto-incrémentée
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('adresse')->nullable();
            $table->foreignId('id_bien')->constrained('biens')->onDelete('cascade'); // Clé étrangère vers 'biens'
            $table->boolean('etat_paiement')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        // Suppression de la table 'locataires'
        Schema::dropIfExists('locataires');
    }
};
