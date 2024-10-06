<?php

namespace Database\Factories;

use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barbershop_id' => Barbershop::all()->random()->id,
            'day' => $this->faker->dayOfWeek(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
        ];
    }
}
