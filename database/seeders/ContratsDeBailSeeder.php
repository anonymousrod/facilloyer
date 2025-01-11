<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\ContratDeBail;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContratsDeBailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les locataires
        $locataires = Locataire::all();

        // Récupérer tous les biens
        $biens = Bien::all();

        foreach ($locataires as $locataire) {
            // Sélectionner un bien au hasard pour ce locataire
            $bien = $biens->random();
            $frequencepaiement = $faker->randomElement(['Mensuel', 'Trimestriel', 'Semestriel', 'Annuel']);
            $dateDebut = Carbon::now()->startOfMonth();
            $dateFin = $dateDebut->copy()->addYear();

            // Créer un contrat de bail pour ce locataire et ce bien
            ContratsDeBail::create([
                'locataire_id' => $locataire->id,
                'bien_id' => $bien->id,
                'reference' => strtoupper($faker->unique()->lexify('CONTRAT-????')),
                'caution' => $faker->numberBetween(1000, 5000),
                'caution_eau' => $faker->numberBetween(50, 200),
                'caution_electricite' => $faker->numberBetween(50, 200),
                'clauses_specifiques1' => $faker->paragraph(),
                'clauses_specifiques2' => $faker->paragraph(),
                'clauses_specifiques3' => $faker->paragraph(),
                'clauses_specifiques4' => $faker->paragraph(),
                'clauses_specifiques5' => $faker->paragraph(),
                'clauses_specifiques6' => $faker->paragraph(),
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'montant_total_frequence' => $faker->randomFloat(2, 100, 1500),
                'frequence_paiement' => $frequencepaiement,
                'penalite_retard' => $faker->numberBetween(1, 50),
                'mode_paiement' => $faker->randomElement(['virement', 'espèces', 'chèque']),
                'renouvellement_automatique' => $faker->boolean(),
                'statut_contrat' => $faker->randomElement(['actif', 'terminé', 'suspendu']),
                'lieu_signature' => $faker->city,
                'date_signature' => $faker->date(),
            ]);
        }
    }
}
