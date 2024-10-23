<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    protected $model = Agent::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'telephone' => $this->faker->unique()->phoneNumber(),
            'adresse' => $this->faker->address(),
        ];
    }
}
