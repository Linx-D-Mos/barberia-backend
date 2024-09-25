<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(6, true),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10000, 70000),
            'barbershop_id' => Barbershop::all()->random()->id,
        ];
    }
}
