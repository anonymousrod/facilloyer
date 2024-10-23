<?php

namespace Database\Factories;

use App\Models\RappelPaiement;
use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Database\Eloquent\Factories\Factory;

class RappelPaiementFactory extends Factory
{
    protected $model = RappelPaiement::class;

    public function definition()
    {
        return [
            'date_rappel' => $this->faker->date(),
            'montant_du' => $this->faker->randomFloat(2, 500, 5000),
            'id_locataire' => Locataire::factory(),
            'id_bien' => Bien::factory(),
        ];
    }
}
