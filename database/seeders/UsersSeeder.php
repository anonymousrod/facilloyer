<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        // $role = Role::where('id', '!=',  1)
        //     ->where('id', '!=', 2) // Exclure le rôle de locataire
        //     ->where('id', '!=', 3) // Exclure le rôle de locataire
        //     ->get()->pluck('id')->toArray();

        // Créer un utilisateur administrateur
        User::create([
            'id_role' => 1,
            'email' => 'texauce@gmail.com',
            'name' => $faker->lastName,
            'password' => Hash::make('texauce69'),
            'statut' => true, // L'admin a toujours un statut à true
        ]);

        // Créer des utilisateurs aléatoires
        // for ($i = 0; $i < 20; $i++) {
        //     $rand_role = $faker->randomElement($role);

        //     // Définir le statut basé sur le rôle
        //     // $faker_statut = ($rand_role == 3) ? false : $faker->boolean();

        //     User::create([
        //         'id_role' => $rand_role,
        //         'name' => $faker->lastName,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => Hash::make('123456789'),
        //         'statut' => $faker->boolean(), // Utilisation de booléens corrects
        //         'must_change_password' => $faker->boolean(), // Utilisation de booléens corrects
        //     ]);
        // }
    }
}
