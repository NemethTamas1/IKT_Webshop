<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MultivitaminSeeder extends Seeder
{
    public function run(): void
    {
        $builderMulti=[
            ["category_id" => 3,
             "description" => "Calcium-Magnesium", "quantity" => 90, "flavour" => "Chocolate", "price" => 10490, "created_at" => now(), "updated_at" => now()],

            'brand' => 'Builder',
            'category_name' => 'multivitamin',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
