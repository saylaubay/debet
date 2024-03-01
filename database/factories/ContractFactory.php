<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => rand(1,60),
            'product_name' => fake()->company(),
            'user_id' => rand(1,3),
            'client_id' => rand(1,30),
            'price' => fake()->numberBetween(15000, 420000),
            'percent' => fake()->numberBetween(10, 90),
            'part' => fake()->numberBetween(3, 18),
        ];
    }
}
