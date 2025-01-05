<?php

namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AgentImmonilierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les utilisateurs ayant le rôle d'agent immobilier
        $agents = User::where('id_role', 3)->get();

        foreach ($agents as $agent) {
            // Vérifier si un agent existe déjà pour cet utilisateur
            if (!AgentImmobilier::where('user_id', $agent->id)->exists()) {
                AgentImmobilier::create([
                    'user_id' => $agent->id,
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
                ]);
            }
        }
    }
}
