<?php

namespace Database\Seeders;

use App\Models\ContratDeBailLocataire;
use App\Models\ContratsDeBail;
use App\Models\Locataire;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratsDeBail_locataireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les contrats de bail
        $contrats = ContratsDeBail::all();

        // Récupérer tous les locataires
        $locataires = Locataire::all();

        // Associer chaque locataire à un ou plusieurs contrats
        foreach ($locataires as $locataire) {
            // Sélectionner entre 1 et 3 contrats de bail aléatoires non attribués
            $contratsSelectionnes = $contrats->random(rand(1, min(3, $contrats->count())));

            foreach ($contratsSelectionnes as $contrat) {
                // Vérifier si cette relation existe déjà
                $exists = ContratDeBailLocataire::where('contrat_de_bail_id', $contrat->id)
                    ->where('locataire_id', $locataire->id)
                    ->exists();

                // Si la relation n'existe pas, la créer
                if (!$exists) {
                    ContratDeBailLocataire::create([
                        'contrat_de_bail_id' => $contrat->id,
                        'locataire_id' => $locataire->id,
                        'date_debut' => $faker->date(),
                        'date_fin' => $faker->date('Y-m-d', '+1 year'),
                        'periode_paiement'=>  $faker->randomElement(['Mensuel', 'Annuel', 'Trimestriel']),
                    ]);
                }
            }
        }
    }
}
