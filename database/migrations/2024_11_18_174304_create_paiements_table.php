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
            $table->foreignId('locataire_id')->constrained()->onDelete('cascade');
            $table->foreignId('bien_id')->constrained()->onDelete('cascade');
            $table->decimal('montant_paye', 10, 2);
            $table->date('date_paiement');
            $table->enum('statut_paiement', ['payé', 'echoué'])->default('echoué');
            $table->string('mode_paiement')->nullable(); // Ex : carte, virement, espèces
            $table->string('reference_paiement')->nullable(); // Référence unique du paiement
            $table->text('description')->nullable(); // Description complémentaire
            $table->timestamps();

            // Index pour améliorer les performances des requêtes
            $table->index(['locataire_id', 'date_paiement']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};