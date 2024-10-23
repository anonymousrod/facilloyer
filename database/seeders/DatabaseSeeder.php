<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
    // Créer 10 agents avec des biens, locataires, paiements, etc.
    \App\Models\Agent::factory(10)
     ->has(\App\Models\Bien::factory(5)->has(\App\Models\Locataire::factory(3)->has(\App\Models\Paiement::factory(5))))
     ->create();
    }

}
