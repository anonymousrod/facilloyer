<?php

namespace Database\Seeders;

use App\Models\ArticleContratBail;
use App\Models\AgentImmobilier;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticleContratBailSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Récupérer tous les agents immobiliers
        $agents = AgentImmobilier::all();

        foreach ($agents as $agent) {
            ArticleContratBail::create([
                'agent_immobilier_id' => $agent->id,
                'titre_article' => $faker->sentence(),
                'contenu_article' => $faker->paragraph(5),
            ]);
        }
    }
}
