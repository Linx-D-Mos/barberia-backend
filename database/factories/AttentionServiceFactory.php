<?php

namespace Database\Factories;

//yo y que
use App\Models\AttentionService;
use App\Models\Service;
use App\Models\Attention;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttentionService>
 */
class AttentionServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attention_id' => Attention::all()->random()->id,
            'service_id' => Service::all()->random()->id,
        ];
    }
}
