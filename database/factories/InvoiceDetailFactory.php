<?php

namespace Database\Factories;

//yo y que
use App\Models\InvoiceDetail;
use App\Models\Invoice;
use App\Models\AttentionService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceDetail>
 */
class InvoiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'attention_service_id' => AttentionService::factory(),
            'value_paid' => $this->faker->randomFloat(2, 0, 1000), // valor pagado entre 0 y 1000
            'descount' => $this->faker->boolean(), // aplicando descuento falso o verdadero
            'descount_value' => $this->faker->randomFloat(2, 0, 100), // valor de descuento
        ];
    }
}
