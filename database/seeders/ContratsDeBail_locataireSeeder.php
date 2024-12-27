<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
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
        $contrats = ContratsDeBail::all();

        foreach ($contrats as $contrat) {
            // Récupérer un locataire déjà assigné au bien de ce contrat
            $locatairesAssignes = $contrat->bien->locataires;

            if ($locatairesAssignes->isNotEmpty()) {
                $locataire = $locatairesAssignes->random();

                $periodePaiement = $faker->randomElement(['Mensuel', 'Trimestriel', 'Semestriel', 'Annuel']);
                $dateDebut = Carbon::now()->startOfMonth();
                $dateFin = $dateDebut->copy()->addYear();

                // Créer un contrat pour le locataire et le bien
                ContratDeBailLocataire::create([
                    'contrat_de_bail_id' => $contrat->id,
                    'locataire_id' => $locataire->id,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin,
                    'periode_paiement' => $periodePaiement,
                    'statut_paiement' => 'En attente',
                    'echeance_paiement' => $this->calculerEcheance($dateDebut, $periodePaiement),
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
