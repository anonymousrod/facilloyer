<?php

namespace Database\Seeders;

use App\Models\Abonnement;
use App\Models\AgentImmobilier;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupère tous les plans existants
        $plans = Plan::all();

        // Récupère tous les agents
        $agents = AgentImmobilier::all();

        foreach ($agents as $agent) {
            // Choisir un plan aléatoire
            $plan = $plans->random();

            $dateDebut = Carbon::now();
            $dateFin = $dateDebut->copy()->addDays($plan->duree);

            // Créer l’abonnement
            Abonnement::create([
                'agent_id' => $agent->id,
                'plan_id' => $plan->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'status' => 'actif',
            ]);
        }
    }
}
