<?php

namespace Database\Factories;

use App\Models\Paiement;
use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaiementFactory extends Factory
{
    protected $model = Paiement::class;

    public function definition()
    {
        return [
            'locataire_id' => Locataire::factory(),
            'bien_id' => Bien::factory(),
            'montant' => $this->faker->randomFloat(2, 1000, 5000),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['Payé', 'attente']),
        ];
    }
}
