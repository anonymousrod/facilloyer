<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->bigIncrements('id_facture');
            $table->float('montant');
            $table->date('date');
            $table->unsignedBigInteger('id_locataire');
            $table->unsignedBigInteger('id_bien');
            $table->boolean('statut')->default(false); // Payée ou non

            // Clés étrangères
            $table->foreign('id_locataire')->references('id_locataire')->on('locataires')->onDelete('cascade');
            $table->foreign('id_bien')->references('id')->on('biens')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
};
