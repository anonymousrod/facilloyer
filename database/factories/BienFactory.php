<?php

namespace Database\Factories;

use App\Models\Bien;
use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class BienFactory extends Factory
{
    protected $model = Bien::class;

    public function definition()
    {
        return [
            'adresse' => $this->faker->address(),
            'type_bien' => $this->faker->randomElement(['appartement', 'maison', 'bureau']),
            'statut' => $this->faker->randomElement(['disponible', 'loué', 'maintenance']),
            'id_agent' => Agent::factory(), // Génère automatiquement un agent associé
        ];
    }
}
