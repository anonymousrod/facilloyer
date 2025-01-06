<?php

namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\Bien;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class BienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $AgentImmobiliers = AgentImmobilier::all()->pluck('id')->toArray();

        foreach ($AgentImmobiliers as  $AgentImmobilier) {
            // creer un random de nombre de bien pour chaque agent immobilier
            $nb_bien = rand(20, 30);
            for ($i=0; $i < $nb_bien ; $i++) {
                Bien::create([
                    'agent_immobilier_id' => $AgentImmobilier,
                    'name_bien'=> $faker->name,
                    'type_bien' =>  $faker->randomElement(['Appartement', 'Maison', 'Studio']),
                    'adresse_bien' => $faker->address,
                    'nombre_de_piece' => $faker->numberBetween(1, 10),
                    'nbr_chambres' => $faker->numberBetween(1, 10),
                    'nbr_salles_de_bain' => $faker->numberBetween(1, 10),
                    'superficie' => $faker->numberBetween(20, 500), // m²
                    // 'annee_construction' => $faker->year(),
                    'description' => $faker->paragraph(),
                    'loyer_mensuel'=> $faker->randomFloat(2, 200, 2000),
                    'photo_bien' => '/storage/facker/photo_bien/' . rand(1, 15) . '.JPG',
                    'photo2_bien' => '/storage/facker/photo_bien/' . rand(1, 15) . '.JPG',
                    'photo3_bien' => '/storage/facker/photo_bien/' . rand(1, 15) . '.JPG',
                    'statut_bien'=> $faker->randomElement(['Disponible', 'Loué', 'En maintenance']),
                ]);
            }
        }
    }
}
