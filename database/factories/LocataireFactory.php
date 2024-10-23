<?php

namespace Database\Factories;

use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocataireFactory extends Factory
{
    protected $model = Locataire::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telephone' => $this->faker->unique()->phoneNumber(),
            'adresse' => $this->faker->address(),
            'id_bien' => Bien::factory(), // Génère automatiquement un bien associé
            'etat_paiement' => $this->faker->boolean(),
        ];
    }
}
