<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(), 
            'slug' => fake()->unique()->slug(),
            'sku' => fake()->unique()->bothify('PROD-####'),
            'img_thumb' => fake()->imageUrl(640, 480, 'product', true),
            'description' => fake()->paragraph(),
            'price_min' => fake()->randomFloat(2, 10, 50),
            'price_max' => fake()->randomFloat(2, 50, 100),
            'category_id' => Category::inRandomOrder()->first()->id, 
            'view' => fake()->numberBetween(0, 1000),
        ];
    }
}
