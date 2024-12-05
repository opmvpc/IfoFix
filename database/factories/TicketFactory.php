<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'clientId' => Client::factory(),
            // 'deviceId' => Device::factory(),
            'clientId' => 1,
            'deviceId' => 1,
            'userId' => User::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'isFinished' => $this->faker->boolean(),
            'isDelivered' => $this->faker->boolean(),
        ];
    }
}
