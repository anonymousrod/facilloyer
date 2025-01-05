<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('demandes_maintenance', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('locataire_id');
        $table->unsignedBigInteger('agent_id')->nullable();
        $table->string('libelle');
        $table->text('description');
        $table->string('statut')->default('En attente');
        $table->timestamps();

        $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade');
        $table->foreign('agent_id')->references('id')->on('agent_immobilier')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_maintenance');
    }
};
