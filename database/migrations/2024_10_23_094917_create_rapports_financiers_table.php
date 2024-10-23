<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapports_financiers', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->date('date_rapport');
            $table->unsignedBigInteger('id_proprietaire');
            $table->unsignedBigInteger('id_agent');
            $table->float('total_revenus'); // Total des revenus pour la période
            $table->text('détails_paiements'); // Détails des paiements dans le rapport
            $table->boolean('envoyé')->default(false); // Statut envoyé ou non
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_proprietaire')->references('id')->on('proprietaires')->onDelete('cascade');
            $table->foreign('id_agent')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapports_financiers');
    }
};
