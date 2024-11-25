<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\Locataire;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocataireBienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer une instance de Faker pour générer des données factices si nécessaire
        $faker = Factory::create();

        // Récupérer tous les biens
        $biens = Bien::all();

        // Récupérer tous les locataires
        $locataires = Locataire::all();

        // Itérer sur chaque locataire
        foreach ($locataires as $locataire) {

            // Sélectionner entre 1 et 3 biens pour chaque locataire, sans dépasser le nombre total de biens
            $biensSelectionnes = $biens->random(rand(1, min(3, $biens->count())));

            // Itérer sur les biens sélectionnés pour ce locataire
            foreach ($biensSelectionnes as $bien) {

                // Vérifier si ce locataire est déjà associé à ce bien
                $exists = $locataire->biens()->where('bien_id', $bien->id)->exists();

                // Si l'association n'existe pas, on crée une nouvelle relation dans la table pivot
                if (!$exists) {
                    $locataire->biens()->attach($bien->id);
                }
            }
        }
    }

}
