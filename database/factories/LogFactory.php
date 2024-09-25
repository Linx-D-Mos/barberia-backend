<?php

namespace Database\Factories;

//yo y que
use App\Models\Log;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_name' => $this->faker->word(),
            'operation' => $this->faker->randomElement(['insert', 'update', 'delete']), // operación a realizar
            'function' => $this->faker->word(), // nombre de la función
            'row_id' => $this->faker->randomNumber(), // id de la fila afectada
            'old_values' => json_encode($this->faker->words(3)), // valores viejos
            'new_values' => json_encode($this->faker->words(3)), // nuevos valores
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(), // Agente de usuario
            'browser' => $this->faker->word(),
            'platform' => $this->faker->word(),
            'created_at' => $this->faker->dateTime(), // Fecha y hora de creación
        ];
    }
}
