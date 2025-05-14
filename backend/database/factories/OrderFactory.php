<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            "user_id" => fake()->numberBetween(1, 30),
            "orderstatus" => 'pending',
            "totalamount" => fake()->numberBetween(290, 30_000),
            "totalquantity" => fake()->numberBetween(1, 5),
        ];
    }
}
