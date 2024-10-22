<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * JE FAIS LES DIFFERENT MIGRATION CONCERNANT AGENT ICI
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id(); 
            $table->string('email')->unique();
            $table->string('telephone')->unique(); 
            $table->string('adresse')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * COMME PAR DEFAUT JE FAIRE LES FONCTION DE BASE RETROO ICI (ta compris)
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};