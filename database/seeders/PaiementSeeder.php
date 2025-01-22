<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\ContratsDeBail;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Locataire;
use App\Models\Bien;

class PaiementSeeder extends Seeder
{
    public function run()
    {
        // Récupérer tous les locataires et biens existants
        $locataires = Locataire::all();
        $biens = Bien::all();

        // Générer des paiements aléatoires
        foreach ($locataires as $locataire) {
            foreach ($biens as $bien) {
                for ($i = 0; $i < rand(1, 5); $i++) { // Générer entre 1 et 5 paiements par locataire et par bien
                    Paiement::create([
                        'locataire_id' => $locataire->id,
                        'bien_id' => $bien->id,
                        'montant_paye' => rand(15000, 100000),
                        'date_paiement' => fake()->date(),
                        'statut_paiement' => fake()->randomElement(['payé', 'echoué']),
                        'mode_paiement' => fake()->randomElement(['carte', 'virement', 'especes']),
                        'reference_paiement' => fake()->uuid(),
                        'description' => fake()->paragraph(),

                    ]);
                }
            }
        }
    }
}
