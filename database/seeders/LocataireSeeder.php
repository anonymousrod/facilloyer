<?php
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

        // Récupérer tous les utilisateurs ayant le rôle de locataire
        $locataires = User::where('id_role', 2)->get();

        // Récupérer tous les agents immobiliers
        $agents_id = AgentImmobilier::all()->pluck('id')->toArray();

        foreach ($locataires as $locataire) {
            // Vérifier si un locataire existe déjà pour cet utilisateur
            if (!Locataire::where('user_id', $locataire->id)->exists()) {
                Locataire::create([
                    'user_id' => $locataire->id,
                    'agent_id' => $faker->randomElement($agents_id),
                    'nom' => $faker->lastName,
                    'prenom' => $faker->firstName,
                    'adresse' => $faker->address,
                    'telephone' => $faker->phoneNumber,
                    'date_naissance' => $faker->date(),
                    'genre' => $faker->randomElement(['Masculin', 'Féminin']),
                    'revenu_mensuel' => $faker->numberBetween(25000, 6500000),
                    'nombre_personne_foyer' => $faker->numberBetween(1, 5),
                    'statut_matrimoniale' => $faker->randomElement(['Célibataire', 'Marié']),
                    'statut_professionnel' => $faker->jobTitle,
                    'garant' => $faker->name,
                    'photo_profil' => '/storage/facker/profile/' . rand(1, 19) . '.JPG',
                ]);
            }
        }
    }
}
