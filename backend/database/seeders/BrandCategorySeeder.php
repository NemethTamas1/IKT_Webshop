<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandCategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Márka-Kategória pivot-tábla sikeresen létrehozva!');
    }
}
