<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id_notification');
            $table->string('contenu');
            $table->dateTime('date_envoi');
            $table->string('destinataire'); // Email ou téléphone
            $table->enum('type', ['rappel', 'alerte', 'info']); // Type de notification
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
