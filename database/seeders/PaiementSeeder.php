<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\Paiement;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory;

class PaiementSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

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
                continue;
            }

            $bienId = $contratDeBail->bien->id;

            // Déterminer la date de début et de fin
            $dateDebut = Carbon::parse($contratLocataire->date_debut);
            $dateFin = Carbon::parse($contratLocataire->date_fin);

            // Déterminer la fréquence de paiement
            $periodePaiement = $contratLocataire->periode_paiement;
            $moisParPeriode = match ($periodePaiement) {
                'Mensuel' => 1,
                'Trimestriel' => 3,
                'Semestriel' => 6,
                'Annuel' => 12,
                default => 1,
            };

            // Calculer le montant pour chaque période
            $loyerMensuel = $contratDeBail->bien->loyer_mensuel;
            $montantPeriode = $loyerMensuel * $moisParPeriode;

            // Générer les paiements pour chaque période
            $dateCourante = $dateDebut;
            while ($dateCourante < $dateFin) {
                Paiement::create([
                    'locataire_id' => $locataireId,
                    'bien_id' => $bienId,
                    'montant' => $montantPeriode,
                    'date' => $dateCourante,
                    'status' => $this->faker->randomElement(['Payé', 'attente']),
                    'description_paiement' => $this->faker->sentence,  // Description générée aléatoirement
                ]);

                $dateCourante->addMonths($moisParPeriode);
            }
        }
    }
}
