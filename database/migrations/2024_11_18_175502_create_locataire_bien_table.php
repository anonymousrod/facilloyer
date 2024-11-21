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
        Schema::create('locataire_bien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locataire_id')->constrained('locataires'); // Locataire
            $table->foreignId('bien_id')->constrained('biens'); // Bien concerné
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locataire_bien');
    }
};
