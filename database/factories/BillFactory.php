<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? null, 
            'user_name' => fake()->name(),
            'user_email' => fake()->safeEmail(),
            'user_phone' => fake()->phoneNumber(),
            'user_address' => fake()->address(),
            'total' => fake()->numberBetween(100000, 500000), 
            'payment_method' => fake()->randomElement(['cod', 'online']),
            'status' => fake()->randomElement(['1', '2', '3', '4', '5', '6']),
            'note' => fake()->optional()->sentence(),
            'voucher_id' => Voucher::inRandomOrder()->first()->id ?? null, 
            'order_code' => 'ORD-' . strtoupper(Str::random(8)),
        ];
    }
}
