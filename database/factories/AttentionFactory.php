<?php

namespace Database\Factories;

//yo y que
use App\Models\Attention;
use App\Models\Profile;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attention>
 */
class AttentionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quote_id' => Quote::all()->random()->id,
            'client_id' => Profile::all()->random()->id,
            'barber_id' => Profile::all()->random()->id,
            'tag' => $this->faker->word(),
        ];
    }
}
