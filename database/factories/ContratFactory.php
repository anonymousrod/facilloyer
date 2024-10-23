<?php

namespace Database\Factories;

use App\Models\Contrat;
use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratFactory extends Factory
{
    protected $model = Contrat::class;

    public function definition()
    {
        return [
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'montant_loyer' => $this->faker->randomFloat(2, 500, 5000),
            'conditions' => $this->faker->sentence(),
            'id_locataire' => Locataire::factory(),
            'id_bien' => Bien::factory(),
        ];
    }
}
