<?php

namespace Database\Factories;

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
            ['name' => 'iPhone 13', 'brandId' => 1, 'typeId' => 1],
            ['name' => 'Galaxy S21', 'brandId' => 2, 'typeId' => 1],
            ['name' => 'iPad Pro', 'brandId' => 1, 'typeId' => 2],
            ['name' => 'Galaxy Tab S7', 'brandId' => 2, 'typeId' => 2],
            ['name' => 'HP Pavillon', 'brandId' => 3, 'typeId' => 3],
            ['name' => 'Asus Zenbook', 'brandId' => 4, 'typeId' => 3],
            ['name' => 'Acer Nitro', 'brandId' => 5, 'typeId' => 3],
        ];

        return [
        // retourne une ligne differentes a chaque fatory et pas deux fois la meme
            'name' => $devices[$this->faker->numberBetween(0, 6)]['name'],
            'brandId' => $devices[$this->faker->numberBetween(0, 6)]['brandId'],
            'typeId' => $devices[$this->faker->numberBetween(0, 6)]['typeId'],
        ];

}