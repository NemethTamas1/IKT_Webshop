<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'brand' => 'Builder',
                'category_name' => 'Protein',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'brand' => 'Scitec',
                'category_name' => 'Protein',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'brand' => 'Pro Nutrition',
                'category_name' => 'Protein',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
            $this->command->info("Kategória létrehozva: {$category['brand']}");
        }
    }
}
