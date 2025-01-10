<?php

namespace Database\Seeders;

use App\Models\Bien;
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
            $frequencePaiement = $faker->randomElement(['Mensuel', 'Trimestriel', 'Semestriel', 'Annuel']);
            $dateDebut = Carbon::now()->startOfMonth();
            $dateFin = $dateDebut->copy()->addYear();

            // Calculer le montant_total_frequence basé sur la fréquence de paiement
            $loyerMensuel = $bien->loyer_mensuel;  // Assurez-vous que cette colonne existe dans le modèle Bien
            $nombreMois = match ($frequencePaiement) {
                'Mensuel' => 1,
                'Trimestriel' => 3,
                'Semestriel' => 6,
                'Annuel' => 12,
            };

            $montantTotalFrequence = $loyerMensuel * $nombreMois;

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
                'montant_total_frequence' => $montantTotalFrequence,  // Calculé selon le loyer mensuel et la fréquence
                'frequence_paiement' => $frequencePaiement,
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
