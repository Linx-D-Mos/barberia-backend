<?php

namespace Database\Factories;

//yo y que
use App\Models\Profile;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Profile::all()->random()->id,
            'date' => $this->faker->date(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
