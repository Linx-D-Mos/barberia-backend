<?php

namespace Database\Factories;

//yo y que
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'), // fecha aleatoria dentro del último año
            'total' => $this->faker->randomFloat(2, 50, 5000), // un total entre 50 y 5000
            'payment_method' => $this->faker->randomElement(['credit_card', 'cash', 'paypal']), // forma de pago
            'status' => $this->faker->randomElement(['paid', 'pending', 'canceled']), // estado de la factura
        ];
    }
}
