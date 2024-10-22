<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Création de la table 'biens'
        Schema::create('biens', function (Blueprint $table) {
            $table->bigIncrements('id'); // Clé primaire auto-incrémentée
            $table->string('adresse');
            $table->string('type_bien');
            $table->enum('statut', ['disponible', 'loué', 'maintenance']);
            $table->foreignId('id_agent')->constrained('agents'); // Clé étrangère vers la table 'agents'
            $table->timestamps();
        });
    }

    public function down()
    {
        // Suppression de la table 'biens'
        Schema::dropIfExists('biens');
    }
};
