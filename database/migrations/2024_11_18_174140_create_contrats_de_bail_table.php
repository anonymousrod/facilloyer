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
            $table->unsignedBigInteger('locataire_id');
            $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade')->onUpdate('restrict');
            $table->string('reference')->unique(); // Référence unique du contrat
            // $table->float('loyer_mensuel');
            $table->float('caution'); // Dépôt de garantie
            $table->float('caution_eau')->nullable();
            $table->float('caution_electricite')->nullable();
            // $table->string('adresse_bien');

            //new
            $table->date('date_debut');//du contrat
            $table->date('date_fin')->nullable();//du contrat
            // $table->float('montant_restant')->nullable();  Montant restant pour la période en cours
            $table->float('montant_total_frequence')->nullable(); // Montant total attendu pour une période mensuel
            $table->string('frequence_paiement'); // Exemple : mensuel, trimestriel
            $table->string('penalite_retard')->nullable();
            $table->string('mode_paiement'); // Exemple : virement, espèces
            $table->boolean('renouvellement_automatique')->default(false); // Renouvellement automatique
            //ajouter article ou pas
            $table->boolean('ajouter_articles_par_defaut')->default(false);
            $table->string('statut_contrat')->default('actif'); // Statut du contrat : actif, terminé, etc.
            // Signatures
            $table->string('lieu_signature');
            $table->date('date_signature');
            $table->longText('signature_agent_immobilier')->nullable();
            $table->longText('signature_locataire')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
