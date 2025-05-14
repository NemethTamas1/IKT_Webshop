<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $unit_price = 5_000;
        $ordered_quantity = 2;
        $total_amount = $unit_price * $ordered_quantity;
        return [
            "order_id" => 1,
            "product_variant_id" => 1, // Wpp - Scitec pl.
            "ordered_quantity" => $ordered_quantity,
            "unit_price" => $unit_price,
            "total_amount" => $total_amount,
        ];
    }
}
