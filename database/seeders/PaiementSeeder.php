<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Paiement;
use App\Models\ContratsDeBail;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $contrats = ContratsDeBail::all();

        foreach ($contrats as $contrat) {
            $montantTotalFrequence = $contrat->montant_total_frequence;
            $frequencePaiement = $contrat->frequence_paiement;
            $dateDebutPaiement = Carbon::parse($contrat->date_debut)->addMonths(3); // Paiement commence au 4e mois
            $dateFin = Carbon::parse($contrat->date_fin);

            // Déterminer l'intervalle en fonction de la fréquence de paiement
            $interval = match ($frequencePaiement) {
                'Mensuel' => 1,
                'Trimestriel' => 3,
                'Semestriel' => 6,
                'Annuel' => 12,
            };

            // Initialisation des paiements fractionnés
            $currentDate = $dateDebutPaiement;

            while ($currentDate < $dateFin) {
                $finFrequence = $currentDate->copy()->addMonths($interval)->subDay();
                $montantPayeTotal = 0;
                $montantRestant = $montantTotalFrequence;

                // Simulation de paiements fractionnés pendant cette période
                while ($montantRestant > 0) {
                    // Si c'est le dernier paiement, ajuster le montant payé pour qu'il corresponde exactement au montant restant
                    if ($montantRestant < 5000) {
                        $montantPaye = $montantRestant;
                    } else {
                        // Sinon, payer un montant entre 50 et 500
                        $montantPaye = $faker->numberBetween(5000, min(50000, $montantRestant));
                    }

                    $montantRestant -= $montantPaye;
                    $montantPayeTotal += $montantPaye;

                    // S'assurer que le montant restant ne soit pas négatif
                    $montantRestant = max(0, $montantRestant);

                    // Déterminer le statut de paiement
                    $statutPaiement = $montantRestant > 0 ? "Partiellement payé" : "Totalement payé";

                    // Création du paiement fractionné
                    Paiement::create([
                        'locataire_id' => $contrat->locataire_id,
                        'bien_id' => $contrat->bien_id,
                        'montant_paye' => $montantPaye,
                        'montant_restant' => $montantRestant,
                        'statut_paiement' => $statutPaiement,
                        'date_debut_frequence' => $currentDate,
                        'date_fin_frequence' => $finFrequence,
                        'frequence_paiement' => $frequencePaiement,
                        'montant_total_frequence' => $montantTotalFrequence, // Ajouter le montant total de la fréquence
                        'description' => "Montant payé à ce jour : $montantPayeTotal FCFA.",
                    ]);

                    // Pause aléatoire pour simuler plusieurs paiements dans la période
                    $currentDate->addDays($faker->numberBetween(5, 15));
                    if ($currentDate > $finFrequence) break; // Ne pas dépasser la fin de la période
                }

                // Passer à la prochaine fréquence de paiement
                $currentDate = $finFrequence->addDay();
            }
        }
    }
}



