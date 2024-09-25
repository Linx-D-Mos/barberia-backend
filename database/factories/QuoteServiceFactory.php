<?php

namespace Database\Factories;

//yo y que
use App\Models\QuoteService;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteService>
 */
class QuoteServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quoteIds = Quote::pluck('id')->toArray();
        $serveceIds = Service::pluck('id')->toArray();
        return [
            'quote_id' => $this->faker->randomElement($quoteIds),
            'service_id' => $this->faker->randomElement($serveceIds),
        ];
    }
}
