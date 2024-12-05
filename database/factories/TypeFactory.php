<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            'Smartphone',
            'Tablet',
            'Laptop',
            'Desktop',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($types),
        ];
    }
}
