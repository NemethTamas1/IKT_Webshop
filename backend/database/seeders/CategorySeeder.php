<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert(['name' => 'protein','description'=>'Fehérjék' ,'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['name' => 'multivitamin','description'=>'Multivitaminok', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['name' => 'vitamin','description'=>'Vitaminok', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['name' => 'clothe', 'description'=>'Ruházat','created_at' => now(), 'updated_at' => now()]);
    }
}
