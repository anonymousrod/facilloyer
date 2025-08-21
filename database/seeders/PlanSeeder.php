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
        // Plan::create([
        //     'nom' => 'Essai',
        //     'prix' => 0,
        //     'duree' => 14,
        //     'description' => 'Période d’essai gratuite de 14 jours',
        // ]);

        // Plan::create([
        //     'nom' => 'Mensuel',
        //     'prix' => 10000,
        //     'duree' => 30,
        //     'description' => 'Abonnement mensuel pour agence immobilière',
        // ]);

        // Plan::create([
        //     'nom' => 'Annuel',
        //     'prix' => 100000,
        //     'duree' => 365,
        //     'description' => 'Abonnement annuel avec réduction de 2 mois',
        // ]);


        // 🌟 Gratuit (Lancement - 1 mois uniquement)
        Plan::create([
            'nom' => 'Gratuit',
            'prix' => 0,
            'duree' => 30,
            'description' => 'Essai gratuit avec toutes fonctionnalités, limité à 20 biens.',
            'limite_biens' => 20,
            'type' => 'mensuel',
            // 'badge' => 'Offre de lancement',
        ]);

        // --------------------
        // 🔹 Starter
        // --------------------
        Plan::create([
            'nom' => 'Starter',
            'prix' => 10999,
            'duree' => 30,
            'description' => 'Jusqu’à 40 biens, locataires illimités, toutes fonctionnalités incluses.',
            'limite_biens' => 40,
            'type' => 'mensuel',
            // 'badge' => null,
        ]);

        Plan::create([
            'nom' => 'Starter',
            'prix' => 109999, // ~2 mois offerts
            'duree' => 365,
            'description' => 'Jusqu’à 40 biens, locataires illimités, toutes fonctionnalités incluses.',
            'limite_biens' => 40,
            'type' => 'annuel',
            // 'badge' => null,
        ]);

        // --------------------
        // 🔹 Pro
        // --------------------
        Plan::create([
            'nom' => 'Pro',
            'prix' => 19999,
            'duree' => 30,
            'description' => 'Jusqu’à 100 biens, locataires illimités, support prioritaire.',
            'limite_biens' => 100,
            'type' => 'mensuel',
            // 'badge' => 'Populaire',
        ]);

        Plan::create([
            'nom' => 'Pro',
            'prix' => 199999, // ~2 mois offerts
            'duree' => 365,
            'description' => 'Jusqu’à 100 biens, locataires illimités, support prioritaire.',
            'limite_biens' => 100,
            'type' => 'annuel',
            // 'badge' => 'Populaire',
        ]);

        // --------------------
        // 🔹 Business
        // --------------------
        Plan::create([
            'nom' => 'Business',
            'prix' => 37999,
            'duree' => 30,
            'description' => 'Biens illimités, locataires illimités, support premium.',
            'limite_biens' => null, // illimité
            'type' => 'mensuel',
            // 'badge' => null,
        ]);

        Plan::create([
            'nom' => 'Business',
            'prix' => 379999, // ~2 mois offerts
            'duree' => 365,
            'description' => 'Biens illimités, locataires illimités, support premium.',
            'limite_biens' => null, // illimité
            'type' => 'annuel',
            // 'badge' => null,
        ]);
    }
}
