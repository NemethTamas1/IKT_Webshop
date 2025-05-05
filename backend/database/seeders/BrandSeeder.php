<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert(['name' => 'Builder', 'Description'=>'Builder Shop', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('brands')->insert(['name' => 'Scitec', 'Description'=>'Scitec Nutrition', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('brands')->insert(['name' => 'Pro Nutrition', 'Description'=>'Pro Nutrition', 'created_at' => now(), 'updated_at' => now()]);
    
        $this->command->info("Gyártók / Márkák szinkronizációja sikeresen megtörtént!");
    }
}
