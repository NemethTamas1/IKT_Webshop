<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            "user_id" => fake()->numberBetween(1, 30),
            "shipping_email" => fake()->safeEmail(),
            "shipping_name" => fake()->name(),
            "shipping_phone" => fake()->phoneNumber(),
            "shipping_country" => "Magyarország",
            "shipping_city" => fake()->randomElement(['Csád', 'Felcsút', 'Szilvásvárad', 'Festetics', 'Kiskőrös']),
            "shipping_zip" => fake()->regexify('[0-9]{4}'),
            "shipping_street_name" => fake()->word() ,
            "shipping_street_type" => fake()->randomElement(['út', 'utca', 'köz', 'tér', 'park', 'dűlő']),
            "shipping_street_number" => fake()->numberBetween(1, 200),
            "totalamount" => fake()->numberBetween(290, 24500),
            "totalquantity" => fake()->numberBetween(1, 5),
        ];
    }
}
