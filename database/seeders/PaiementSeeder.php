<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\Paiement;
use App\Models\LocataireBien;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les contrats de bail locataire
        $contratsLocataires = ContratDeBailLocataire::all();

        foreach ($contratsLocataires as $contratLocataire) {
            // Récupérer le locataire et le contrat de bail
            $locataireId = $contratLocataire->locataire_id;
            $contratDeBail = $contratLocataire->contrats_de_bail;

            // Vérifier si le contrat de bail est valide et récupérer le bien
            if (!$contratDeBail || !$contratDeBail->bien) {
                dump("Contrat de bail ou bien manquant pour le locataire ID : $locataireId");

                continue; // Passer si le contrat ou le bien est manquant
            }

            $bienId = $contratDeBail->bien->id;

            // Vérifier si le locataire est assigné au bien
            $isAssigned = LocataireBien::where('locataire_id', $locataireId)
                ->where('bien_id', $bienId)
                ->exists();

            if (!$isAssigned) {

                continue; // Passer au contrat suivant si non assigné
            }

            // Récupérer les informations nécessaires pour les paiements
            $dateDebut = Carbon::parse($contratLocataire->date_debut);
            $periodePaiement = $contratLocataire->periode_paiement;

            // Déterminer le nombre de mois par période
            $moisParPeriode = match ($periodePaiement) {
                'Mensuel' => 1,
                'Trimestriel' => 3,
                'Semestriel' => 6,
                'Annuel' => 12,
                default => 1,
            };

            // Calculer le montant total pour chaque période
            $loyerMensuel = $contratDeBail->bien->loyer_mensuel;
            $montantTotalPeriode = $loyerMensuel * $moisParPeriode;

            // Générer les paiements pour la durée du contrat
            $dateFin = Carbon::parse($contratLocataire->date_fin);
            $dateCourante = $dateDebut;

            while ($dateCourante < $dateFin) {
                $montantRestant = $montantTotalPeriode;

                // Simuler plusieurs paiements pour couvrir la période
                while ($montantRestant > 0) {
                    // Générer un montant payé aléatoire (au maximum ce qui reste à payer)
                    $montant = min($montantRestant, random_int(5000, 20000));
                    $montantRestant -= $montant;

                    Paiement::create([
                        'locataire_id' => $locataireId,
                        'bien_id' => $bienId,
                        'montant_total_periode' => $montantTotalPeriode,
                        'montant_restant' => $montantRestant,
                        'montant' => $montant,
                        'date' => $dateCourante,
                    ]);
                }

                // Passer à la prochaine période
                $dateCourante->addMonths($moisParPeriode);
            }
        }
    }
}
