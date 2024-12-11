<?php

namespace Database\Seeders;

use App\Models\AgentImmobilier;
use App\Models\Locataire;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocataireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $locataires = User::where('id_role', 2)->get()->pluck('id')->toArray();
        $agents_id = AgentImmobilier::all()->pluck('id')->toArray();

        $rand_agents_id = $faker->randomElement($agents_id);


        foreach ($locataires as $locataire) {
            Locataire::create([
                'user_id' => $locataire ,
                'agent_id' => $rand_agents_id ,
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'adresse' => $faker->address,
                'telephone' => $faker->phoneNumber,
                'date_naissance' => $faker->date(),
                'genre' => $faker->randomElement(['Masculin', 'Féminin']),
                'revenu_mensuel' => $faker->numberBetween(500, 5000),
                'nombre_personne_foyer' => $faker->numberBetween(1, 5),
                'statut_matrimoniale' => $faker->randomElement(['Célibataire', 'Marié']),
                'statut_professionnel' => $faker->jobTitle,
                'garant' => $faker->name,
                'photo_profil' => $faker->imageUrl(150, 150, 'business'),

            ]);
        }

    }
}
