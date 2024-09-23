<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barbershop>
 */
class BarbershopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'address' => fake()->unique()->address(),
            'phone' => fake()->unique()->phoneNumber(),
            'number' => fake()->unique()->buildingNumber(),
            'tokenwaapi' => fake()->unique()->sha256(),
        ];
    }
}
