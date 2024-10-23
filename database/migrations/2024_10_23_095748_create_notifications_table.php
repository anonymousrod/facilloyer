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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('type_notification'); // Email, WhatsApp, etc.
            $table->text('contenu'); // Contenu de la notification
            $table->unsignedBigInteger('id_destinataire'); // Clé étrangère vers locataires
            $table->date('date_envoi');
            $table->boolean('statut_envoi')->default(false); // Envoyé ou non
            $table->timestamps();
            
            // Clé étrangère avec la bonne colonne
            $table->foreign('id_destinataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
