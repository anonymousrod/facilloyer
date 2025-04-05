<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contrat_modification_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contrat_de_bail_id');
            $table->enum('demande_par', ['agent', 'locataire']); // Qui a fait la demande
            $table->text('motif'); // Raison de la demande
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee'])->default('en_attente');
            $table->timestamps();

            $table->foreign('contrat_de_bail_id')
                  ->references('id')
                  ->on('contrats_de_bail')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrat_modification_requests');
    }
};
