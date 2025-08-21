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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Exemple : "Essai", "Mensuel", etc.
            $table->string('type')->default('mensuel'); // mensuel ou annuel

            $table->decimal('prix', 10, 2)->default(0); // Prix du plan (par défaut 0)
            $table->integer('duree'); // Durée en jours (ex: 14, 30, 365)
            $table->integer('limite_biens')->nullable();

            $table->text('description')->nullable(); // Description facultative
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
