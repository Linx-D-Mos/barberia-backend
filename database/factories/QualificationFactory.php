<?php

namespace Database\Factories;

//yo y que
use App\Models\Profile;
use App\Models\Qualification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qualification>
 */
class QualificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'client_id' => Profile::factory(),
            //'barber_id' => Profile::factory(),
            'client_id' => Profile::all()->random()->id,
            'barber_id' => Profile::all()->random()->id,
            'score' => $this->faker->random()->numberBetween(1, 5), // puede ser de 1 a 10 o de 1 a 5
            'comment' => $this->faker->sentence(),
        ];
    }
}
