<?php

namespace Database\Factories;

use App\Models\Proprietaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProprietaireFactory extends Factory
{
    protected $model = Proprietaire::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telephone' => $this->faker->unique()->phoneNumber(),
        ];
    }
}
