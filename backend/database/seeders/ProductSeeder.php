<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Scitec cuccok
        $products = [
            // Kategóriák FK-ja
            $proteinCategory=Category::where('name', 'protein')->first(),
            $multivitaminsCategory=Category::where('name', 'multivitamin')->first(),
            $vitaminsCategory=Category::where('name', 'vitamin')->first(),

            // Márkák FK-ja
            $scitecBrand=Brand::where('name', 'Scitec')->first(),
            $builderBrand=Brand::where('name', 'Builder')->first(),
            $proNutritionBrand=Brand::where('name', 'Pro Nutrition')->first(),
           
            [
                'brand_id' => $scitecBrand->id,
                'category_id' => $proteinCategory->id,
                'name' => '100% Whey Protein Professional',
                'slug' => '100-whey-protein-professional',
                'description' => 'Prémium minőségű tejsavó fehérje formula.',
                'product_line' => 'wpp'
            ],
            [
                'brand_id' => $scitecBrand->id,
                'category_id' => $proteinCategory->id,
                'name' => 'Jumbo!',
                'slug' => 'jumbo',
                'description' => 'Fehérje-komplex a gyors tömegnöveléshez',
                'product_line' => 'Jumbo!'
            ],
            [
                'brand_id' => $scitecBrand->id,
                'category_id' => $multivitaminsCategory->id,
                'name' => 'Mega Daily One',
                'slug' => 'mega-daily-one',
                'description' => 'Komplex multivitamin formula',
                'product_line' => 'megadailyone'
            ],
            [
                'brand_id' => $scitecBrand->id,
                'category_id' => $multivitaminsCategory->id,
                'name' => 'Multi Pro Plus',
                'slug' => 'multi-pro-plus',
                'description' => 'Komplex multivitamin formula',
                'product_line' => 'multiproplus'
            ],
            [
                'brand_id' => $scitecBrand->id,
                'category_id' => $vitaminsCategory->id,
                'name' => 'Calcium Magnesium',
                'slug' => 'calcium-magnesium',
                'description' => 'Komplex kálcium-bevitel fedezésére.',
                'product_line' => 'calciummagnesium'
            ],

            // Builder termékek
            [
                'brand_id' => $builderBrand->id,
                'category_id' => $proteinCategory->id,
                'name' => 'Whey Protein',
                'slug' => 'whey-protein',
                'description' => 'Magas fehérjetartalmú formula',
                'product_line' => 'WheyProtein'
            ],
            [
                'brand_id' => $builderBrand->id,
                'category_id' => $vitaminsCategory->id,
                'name' => 'C vitamin',
                'slug' => 'C-vitamin',
                'description' => 'Erős antioxidáns hatású vitamin',
                'product_line' => 'Cvitamin'
            ],
            [
                'brand_id' => $builderBrand->id,
                'category_id' => $multivitaminsCategory->id,
                'name' => 'Vitaday',
                'slug' => 'Vitaday',
                'description' => 'Komplex napi vitaminbevitelre.',
                'product_line' => 'vitaday'
            ],
            [
                'brand_id' => $builderBrand->id,
                'category_id' => $multivitaminsCategory->id,
                'name' => 'Vitapro Pack',
                'slug' => 'vitapropack',
                'description' => 'Komplex teljes napi vitaminbevitel fedezésére.',
                'product_line' => 'vitapropack'
            ],

            // Pro Nutrition termékek
            [
                'brand_id' => $proNutritionBrand->id,
                'category_id' => $proteinCategory->id,
                'name' => 'Pro Whey',
                'slug' => 'pro-whey',
                'description' => 'Fehérje-mátrix professzionális sportolóknak',
                'product_line' => 'Pro Whey'
            ],
            [
                'brand_id' => $proNutritionBrand->id,
                'category_id' => $multivitaminsCategory->id,
                'name' => 'Daily Health - Komplex',
                'slug' => 'dailyhealt',
                'description' => 'Komplex teljes napi vitaminbevitel fedezésére.',
                'product_line' => 'dailyhealt'
            ],
            [
                'brand_id' => $proNutritionBrand->id,
                'category_id' => $vitaminsCategory->id,
                'name' => 'Dealy Health - C Vitamin',
                'slug' => 'dailyhealt-c-vitamin',
                'description' => 'Komplex napi C-vitamin bevitel.',
                'product_line' => 'dailyhealt-c-vitamin'
            ],
        ];

        foreach ($products as $product) {
            if (is_array($product)) {
                Product::create([
                    'brand_id' => $product['brand_id'],
                    'category_id' => $product['category_id'],
                    'name' => $product['name'],
                    'slug' => Str::slug($product['slug']),
                    'description' => $product['description'],
                    'product_line' => $product['product_line'],
                ]);
            }
        }
        $this->command->info('Alap termékek sikeresen létrehozva!');
    }
}
