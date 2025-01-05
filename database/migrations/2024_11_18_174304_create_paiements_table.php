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
            $table->float('montant'); // Montant payé lors de la transaction
            $table->date('date'); // Date du paiement
            $table->enum('status', ['Payé', 'attente'])->default('attente'); // Statut du paiement , si elle a marché ou elle a eté refusé
            $table->string('description_paiement'); // Description du paiement , ex: paiement d'ue partie de la location
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
            $table->dropColumn(['montant_total_periode',]);
        });
    }
};
