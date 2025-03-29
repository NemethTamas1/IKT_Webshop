<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::with('categories')->get();
        $pivotData = [];

        foreach ($products as $product) {
            $category = Category::find($product->category_id);

            $stock = 5; // egyelőre jó így, majd Servicebe / Policybe a dinamikus elérhető + készletet megírhatjuk!
            $available = $stock > 0;

            $pivotData[] = [
                'category_id' => $product->category_id,
                'category_name' => $category->category_name,
                'product_id' => $product->id,
                'stock' => $stock,
                'available' => $available,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        foreach (array_chunk($pivotData, 100) as $chunk) {
            DB::table('category_product')->insert($chunk);
        }
        $this->command->info('Kategória-termék pivot-tábla sikeresen létrehozva!');
    }
}
