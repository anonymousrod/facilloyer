<?php

namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentImmonilierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $agents = User::where('id_role', 3)->get()->pluck('id')->toArray();

        foreach ($agents as $agent) {
            AgentImmobilier::create([
                'user_id' => $agent ,
                'nom_agence' => $faker->company,
                'nom_admin' => $faker->lastName,
                'prenom_admin' => $faker->firstName,
                'telephone_agence' => $faker->phoneNumber,
                'annee_experience' => $faker->numberBetween(1, 20),
                'adresse_agence' => $faker->address,
                'territoire_couvert' => $faker->city,
                'nombre_bien_disponible' => $faker->numberBetween(1, 100),
                'photo_profil' => '/storage/facker/profile/' . rand(1, 19) . '.JPG',
                'carte_identite_pdf' => '/storage/facker/carte_identite_pdf/' . rand(1, 6) . '.PDF',
                'rccm_pdf' => '/storage/facker/rccm_pdf/' . rand(1, 6) . '.PDF',
                // 'photo_profil' => $faker->imageUrl(150, 150, 'business'),

            ]);
        }

    }
}
