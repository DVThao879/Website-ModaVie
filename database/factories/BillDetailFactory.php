<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillDetail>
 */
class BillDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bill_id' => Bill::inRandomOrder()->first()->id, 
            'product_variant_id' => ProductVariant::inRandomOrder()->first()->id ?? null,
            'product_name' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 10),
            'price' => fake()->randomFloat(2, 10, 500),
            'size' => fake()->randomElement(['S', 'M', 'L', 'XL']),
            'color' => fake()->randomElement(['Red', 'Blue', 'Green']),
        ];
    }
}
