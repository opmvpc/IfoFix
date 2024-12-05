<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $devices = [
            'iPhone 13',
            'Galaxy S21',
            'iPad Pro',
            'Galaxy Tab S7',
            'HP Pavillon',
            'Asus Zenbook',
            'Acer Nitro',
        ];

        return [
            'name' => $this->faker->randomElement($devices),
            'brandId' => Brand::inRandomOrder()->first()->id,
            'typeId' => Type::inRandomOrder()->first()->id,
        ];
    }
}
