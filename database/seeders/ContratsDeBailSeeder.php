<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\ContratsDeBail;
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

        $biens = Bien::all();

        foreach ($biens as $bien) {
            $nbContrats = rand(1, 3); // Créer entre 1 et 3 contrats pour chaque bien
            for ($i = 0; $i < $nbContrats; $i++) {
                ContratsDeBail::create([
                    'bien_id' => $bien->id,
                    // 'loyer_mensuel' => $bien->loyer_mensuel,
                    'depot_de_garantie' => $bien->loyer_mensuel * 2,
                    // 'adresse_bien' => $bien->adresse_bien,
                    'description' => $faker->paragraph(),
                    'renouvellement_automatique' => $faker->boolean,
                    'penalite_retard' => $faker->randomFloat(2, 10, 50),
                    'type_bien' => $bien->type_bien,
                    'statut_bien' => $bien->statut_bien,
                    'conditions' => $faker->paragraph(),
                ]);
            }
        }
    }
}
