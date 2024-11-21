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
            $table->date('date'); // Date du paiement
            $table->string('statut')->default('partiellement payé'); // Statut du paiement payé, en retard
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
