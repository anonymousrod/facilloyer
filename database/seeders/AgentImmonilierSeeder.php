<?php

// namespace Database\Seeders;

// use App\Models\AgentImmobilier;
// use App\Models\User;
// use Faker\Factory;
// use Illuminate\Database\Seeder;

// class AgentImmonilierSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $faker = Factory::create();

//         // Récupérer tous les utilisateurs ayant le rôle d'agent immobilier
//         $agents = User::where('id_role', 3)->get();

//         foreach ($agents as $agent) {
//             // Vérifier si un agent existe déjà pour cet utilisateur
//             if (!AgentImmobilier::where('user_id', $agent->id)->exists()) {
//                 AgentImmobilier::create([
//                     'user_id' => $agent->id,
//                     'nom_agence' => $faker->company,
//                     'nom_admin' => $faker->lastName,
//                     'prenom_admin' => $faker->firstName,
//                     'telephone_agence' => $faker->phoneNumber,
//                     'annee_experience' => $faker->numberBetween(1, 20),
//                     'adresse_agence' => $faker->address,
//                     'territoire_couvert' => $faker->city,
//                     'nombre_bien_disponible' => $faker->numberBetween(1, 100),
//                     'photo_profil' => '/storage/facker/profile/' . rand(1, 19) . '.JPG',
//                     'carte_identite_pdf' => '/storage/facker/carte_identite_pdf/' . rand(1, 6) . '.PDF',
//                     'rccm_pdf' => '/storage/facker/rccm_pdf/' . rand(1, 6) . '.PDF',
//                 ]);
//             }
//         }
//     }
// }


namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentImmonilierSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Créer des agents immobiliers avec leurs utilisateurs
        for ($i = 0; $i < 20; $i++) {
            $nom_agence = $faker->company;

            // Créer un utilisateur pour l'agent immobilier
            $user = User::create([
                'id_role' => 3, // Rôle d'agent immobilier
                'name' => $nom_agence,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456789'),
                'statut' => $faker->boolean(),
                'must_change_password' => $faker->boolean(),
            ]);

            // Créer un agent immobilier lié à cet utilisateur
            AgentImmobilier::create([
                'user_id' => $user->id,
                'nom_agence' => $nom_agence,
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

