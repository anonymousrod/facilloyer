<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rappels_paiement', function (Blueprint $table) {
            $table->bigIncrements('id_rappel');
            $table->date('date_rappel');
            $table->float('montant_du');
            $table->unsignedBigInteger('id_locataire');
            $table->unsignedBigInteger('id_bien');

            // Clés étrangères
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rappels_paiement');
    }
};
