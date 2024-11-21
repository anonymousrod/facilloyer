<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role = Role::where('id', '!=',  1)->get()->pluck('id')->toArray();

        User::create([
            'id_role' => 1,
            'email' => 'teteganexauce@gmail.com',
            'password' => Hash::make('texauce69')
        ]);

        for ($i=0; $i <11 ; $i++) {
            User::create([
                'id_role' => $faker->randomElement($role),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456789')
            ]);
        }
    }
}
