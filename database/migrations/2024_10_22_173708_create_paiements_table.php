<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Création de la table 'paiements'
        Schema::create('paiements', function (Blueprint $table) {
            $table->bigIncrements('id_paiement'); // Clé primaire auto-incrémentée
            $table->float('montant');
            $table->date('date_paiement');
            $table->string('moyen_paiement'); // Carte bancaire, virement, etc.
            $table->boolean('statut_paiement')->default(false); // Réussi ou échoué
            $table->unsignedBigInteger('id_locataire'); // Clé étrangère vers locataire
            $table->unsignedBigInteger('id_bien'); // Clé étrangère vers bien
            
            // Clé étrangère avec cascade à la suppression
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        // Suppression de la table 'paiements'
        Schema::dropIfExists('paiements');
    }
};
