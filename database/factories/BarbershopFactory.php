<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
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
            'owner_id' => User::all()->random()->id,
            'tokenwaapi' => fake()->unique()->sha256(),
        ];
    }
}
