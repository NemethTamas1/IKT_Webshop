<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('brand')->toArray();
        $products = [
            'Builder' => [
                'weights_prices' => [
                    28 => 290,
                    1000 => 7190,
                    4000 => 25880
                ],
                'flavours' => [
                    'Vanilla',
                    'Chocolate',
                    'Black Raspberry-White Chocolate',
                    'Cookies And Cream'
                ]
            ],
            'Scitec' => [
                'weights_prices' => [
                    30 => 490,
                    500 => 5510,
                    920 => 12490,
                    2350 => 25990,
                    5000 => 49990
                ],
                'flavours' => [
                    'Vanilla',
                    'Chocolate',
                    'Strawberry',
                    'Chocolate-Nuts',
                    'Strawberry-WhiteChoco',
                    'Chocolate-Coconut',
                    'Chocolate-Cookie',
                    'Banana',
                    'Kiwi-Banana',
                    'Coconut',
                    'Lemon-Cheesecake',
                    'Vanilla-Raspberries',
                    'Ice-Coffe',
                    'Peanut-Butter',
                    'Salted-Caramel',
                    'White-Chocolate',
                    'Pistachio-White Chocolate'
                ]
            ],
            'Pro Nutrition' => [
                'weights_prices' => [
                    900 => 11390,
                    2000 => 22290,
                    4000 => 39790
                ],
                'flavours' => [
                    'Vanilla',
                    'Chocolate',
                    'Strawberry'
                ]
            ]
        ];

        $allProducts = [];

        foreach ($products as $brand => $data) {
            $category = (object)$categories[$brand];
            foreach ($data['weights_prices'] as $weight => $price) {
                foreach ($data['flavours'] as $flavour) {
                    $description = match ($brand) {
                        'Builder' => "Whey Protein",
                        'Scitec' => "100% Whey Protein Professional",
                        'Pro Nutrition' => "Pro Whey",
                        default => "Whey Protein"
                    };

                    $allProducts[] = [
                        'category_id' => $category->id,
                        'description' => $description,
                        'weight' => $weight,
                        'flavour' => $flavour,
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        if (!empty($allProducts)) {
            // Ha majd több termék lesz, gyorsabban felseedeli ha 100-as chunkokban küldjük fel.
            foreach (array_chunk($allProducts, 100) as $chunk) {
                DB::table('products')->insert($chunk);
            }
            $this->command->info('Termékek sikeresen létrehozva!');
        } else {
            $this->command->error('Nem sikerült termékeket létrehozni!');
        }
    }
}
