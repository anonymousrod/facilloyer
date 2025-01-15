<?php
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('paiements', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('locataire_id');
//             $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade')->onUpdate('restrict');
//             $table->unsignedBigInteger('bien_id');
//             $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade')->onUpdate('restrict');
//             $table->float('montant'); // Montant payé lors de la transaction
//             $table->date('date'); // Date du paiement
//             $table->enum('status', ['Payé', 'attente'])->default('attente'); // Statut du paiement , si elle a marché ou elle a eté refusé
//             $table->string('description_paiement'); // Description du paiement , ex: paiement d'ue partie de la location
//             $table->timestamps();
//             $table->softDeletes();

//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('paiements');
//         Schema::table('paiements', function (Blueprint $table) {
//             $table->dropColumn(['montant_total_periode',]);
//         });
//     }
// };
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->unsignedBigInteger('locataire_id');
            $table->unsignedBigInteger('bien_id');

            // Champs pour les paiements
            $table->decimal('montant_paye', 10, 2); // Montant payé
            $table->decimal('montant_restant', 10, 2); // Montant restant
            $table->decimal('montant_total_frequence', 10, 2); // Montant restant
            $table->string('statut_paiement')->default('Partiellement payé'); // Partiellement ou totalement payé
            $table->date('date_debut_frequence'); // Début de la période de paiement
            $table->date('date_fin_frequence'); // Fin de la période de paiement
            $table->string('frequence_paiement'); // Ex: Mensuel, Trimestriel
            $table->text('description')->nullable(); // Description complémentaire

            $table->timestamps();

            // Définition des relations et contraintes
            $table->foreign('locataire_id')->references('id')->on('locataires')->onDelete('cascade');
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
