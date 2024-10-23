<?php

namespace Database\Factories;

use App\Models\RapportFinancier;
use App\Models\Proprietaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class RapportFinancierFactory extends Factory
{
    protected $model = RapportFinancier::class;

    public function definition()
    {
        return [
            'contenu' => $this->faker->paragraph(),
            'id_proprietaire' => Proprietaire::factory(),
        ];
    }
}
