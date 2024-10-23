<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Agent;
use App\Models\Locataire;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'contenu' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['email', 'whatsapp']),
            'id_agent' => Agent::factory(),
            'id_locataire' => Locataire::factory(),
        ];
    }
}
