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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locataire_id');
            $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('bien_id');
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade')->onUpdate('restrict');
            $table->float('montant'); // Montant payé
            $table->float('montant_restant')->nullable(); // Montant restant pour la période en cours
            $table->float('montant_total_periode')->nullable(); // Montant total attendu pour une période
            $table->date('date'); // Date du paiement
            // $table->enum('mode_paiement', ['Virement', 'Chèque', 'Espèces'])->nullable(); // Mode de paiement
            // $table->enum('status', ['Payé', 'En attente', 'Retard'])->default('En attente'); // Statut du paiement
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['montant_total_periode', 'montant_restant']);
        });
    }
};
