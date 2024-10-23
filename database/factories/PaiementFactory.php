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
            'montant' => $this->faker->randomFloat(2, 500, 5000),
            'date_paiement' => $this->faker->date(),
            'moyen_paiement' => $this->faker->randomElement(['carte bancaire', 'virement', 'chèque']),
            'statut_paiement' => $this->faker->boolean(),
            'id_locataire' => Locataire::factory(),
            'id_bien' => Bien::factory(),
        ];
    }
}
