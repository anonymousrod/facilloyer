<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\ContratsDeBail;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContratsDeBail_locataireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les contrats de bail existants
        $contrats = ContratsDeBail::with('bien.locataires')->get();

        foreach ($contrats as $contrat) {
            $bien = $contrat->bien;

            // Vérifier si le bien a des locataires assignés
            if ($bien && $bien->locataires->isNotEmpty()) {
                $locataire = $bien->locataires->random();

                $frequencepaiement = $faker->randomElement(['Mensuel', 'Trimestriel', 'Semestriel', 'Annuel']);
                $dateDebut = Carbon::now()->startOfMonth();
                $dateFin = $dateDebut->copy()->addYear();

                // Calculer l'échéance en fonction de la période
                $echeancePaiement = $this->calculerEcheance($dateDebut, $frequencepaiement);

                // Créer un enregistrement pour le contrat de bail locataire
                ContratDeBailLocataire::create([
                    'contrat_de_bail_id' => $contrat->id,
                    'locataire_id' => $locataire->id,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                    'frequence_paiement' => $frequencepaiement,
                    'mode_paiement' => $faker->randomElement(['virement bancaire', 'cash', 'mobile money']),
                    'renouvellement_automatique' => $faker->boolean(50), // 50% true, 50% false
                    'statut_contrat' => $faker->randomElement(['actif', 'terminé', 'resilier']),
                ]);
            }
        }
    }

    /**
     * Calculer l'échéance de paiement en fonction de la période.
     */
    private function calculerEcheance(Carbon $dateDebut, string $periode): Carbon
    {
        return match ($periode) {
            'Mensuel' => $dateDebut->copy()->addMonth(),
            'Trimestriel' => $dateDebut->copy()->addMonths(3),
            'Semestriel' => $dateDebut->copy()->addMonths(6),
            'Annuel' => $dateDebut->copy()->addYear(),
        };
    }
}
