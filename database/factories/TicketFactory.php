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
            'clientId' => Client::inRandomOrder()->first()->id,
            'deviceId' => Device::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'isFinished' => fake()->boolean(),
            'isDelivered' => $this->faker->boolean(),
        ];
    }
}
