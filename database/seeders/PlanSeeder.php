<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'nom' => 'Essai',
            'prix' => 0,
            'duree' => 14,
            'description' => 'Période d’essai gratuite de 14 jours',
        ]);

        Plan::create([
            'nom' => 'Mensuel',
            'prix' => 10000,
            'duree' => 30,
            'description' => 'Abonnement mensuel pour agence immobilière',
        ]);

        Plan::create([
            'nom' => 'Annuel',
            'prix' => 100000,
            'duree' => 365,
            'description' => 'Abonnement annuel avec réduction de 2 mois',
        ]);
    }
}
