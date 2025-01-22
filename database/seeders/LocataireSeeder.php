<?php
// namespace Database\Seeders;

// use App\Models\AgentImmobilier;
// use App\Models\Locataire;
// use App\Models\User;
// use Faker\Factory;
// use Illuminate\Database\Seeder;

// class LocataireSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $faker = Factory::create();

//         // Récupérer tous les utilisateurs ayant le rôle de locataire
//         $locataires = User::where('id_role', 2)->get();

//         // Récupérer tous les agents immobiliers
//         $agents_id = AgentImmobilier::all()->pluck('id')->toArray();

//         foreach ($locataires as $locataire) {
//             // Vérifier si un locataire existe déjà pour cet utilisateur
//             if (!Locataire::where('user_id', $locataire->id)->exists()) {
//                 Locataire::create([
//                     'user_id' => $locataire->id,
//                     'agent_id' => $faker->randomElement($agents_id),
//                     'nom' => $faker->lastName,
//                     'prenom' => $faker->firstName,
//                     'adresse' => $faker->address,
//                     'telephone' => $faker->phoneNumber,
//                     'date_naissance' => $faker->date(),
//                     'genre' => $faker->randomElement(['Masculin', 'Féminin']),
//                     'revenu_mensuel' => $faker->numberBetween(500, 5000),
//                     'nombre_personne_foyer' => $faker->numberBetween(1, 5),
//                     'statut_matrimoniale' => $faker->randomElement(['Célibataire', 'Marié']),
//                     'statut_professionnel' => $faker->jobTitle,
//                     'garant' => $faker->name,
//                     'photo_profil' => '/storage/facker/profile/' . rand(1, 19) . '.JPG',
//                 ]);
//             }
//         }
//     }
// }

namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\Locataire;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class LocataireSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les agents immobiliers
        $agents_id = AgentImmobilier::all()->pluck('id')->toArray();

        // Créer 20 locataires
        for ($i = 0; $i < 20; $i++) {
            $nom = $faker->lastName;
            $prenom = $faker->firstName;

            // Créer un utilisateur pour le locataire
            $user = User::create([
                'id_role' => 2, // Rôle de locataire
                'name' => "$nom $prenom",
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('123456789'),
                'statut' => $faker->boolean(),
                'must_change_password' => $faker->boolean(),
            ]);

            // Créer un locataire associé à cet utilisateur
            Locataire::create([
                'user_id' => $user->id,
                'agent_id' => $faker->randomElement($agents_id),
                'nom' => $nom,
                'prenom' => $prenom,
                'adresse' => $faker->address,
                'telephone' => $faker->phoneNumber,
                'date_naissance' => $faker->date(),
                'genre' => $faker->randomElement(['Masculin', 'Féminin']),
                'revenu_mensuel' => $faker->numberBetween(500, 5000),
                'nombre_personne_foyer' => $faker->numberBetween(1, 5),
                'statut_matrimoniale' => $faker->randomElement(['Célibataire', 'Marié']),
                'statut_professionnel' => $faker->jobTitle,
                'garant' => $faker->name,
                'photo_profil' => '/storage/facker/profile/' . rand(1, 19) . '.JPG',
            ]);
        }
    }
}
