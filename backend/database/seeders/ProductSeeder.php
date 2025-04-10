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
        $wppProducts = [
            'Scitec' => [
                'weights_prices' => [
                    30 => 490,
                    500 => 5510,
                    920 => 12490,
                    2350 => 25990,
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
        ];
        // 5kg | Nincs minden íz!
        $wpp5000Products = [
            'Scitec' => [
                'weights_prices' => [
                    5000 => 49990
                ],
                'flavours' => [
                    'Chocolate-Cookie',
                    'Lemon-Cheesecake',
                    'Chocolate',
                    'Vanilla',
                    'Chocolate-Nuts',
                    'Strawberry-WhiteChoco',
                    'Chocolate-Coconut',
                    'Banana',
                    'Vanilla-Raspberries',
                    'Strawberry',
                ]
            ]
        ];

        $otherProducts = [
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
        // WPP (kivéve az ötezres) felküldése
        foreach ($wppProducts as $brand => $data) {
            $category = (object)$categories[$brand];
            foreach ($data['weights_prices'] as $weight => $price) {
                foreach ($data['flavours'] as $flavour) {
                    $allProducts[] = [
                        'category_id' => $category->id,
                        'description' => "100% Whey Protein Professional",
                        'weight' => $weight,
                        'flavour' => $flavour,
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        // 5000g-os WPP az ízdifi miatt
        foreach ($wpp5000Products as $brand => $data) {
            $category = (object)$categories[$brand];
            foreach ($data['weights_prices'] as $weight => $price) {
                foreach ($data['flavours'] as $flavour) {
                    $allProducts[] = [
                        'category_id' => $category->id,
                        'description' => "100% Whey Protein Professional",
                        'weight' => $weight,
                        'flavour' => $flavour,
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        // Minden más
        foreach ($otherProducts as $brand => $data) {
            $category = (object)$categories[$brand];
            foreach ($data['weights_prices'] as $weight => $price) {
                foreach ($data['flavours'] as $flavour) {
                    $allProducts[] = [
                        'category_id' => $category->id,
                        'description' => match ($brand) {
                            'Builder' => "Whey Protein",
                            'Pro Nutrition' => "Pro Whey",
                            default => "Whey Protein"
                        },
                        'weight' => $weight,
                        'flavour' => $flavour,
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }
        // JUMBO!
        $jumboProducts = [
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 1320, "flavour" => "Chocolate", "price" => 10490, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 1320, "flavour" => "Vanilla", "price" => 10490, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 1320, "flavour" => "Strawberry", "price" => 10490, "created_at" => now(), "updated_at" => now()],

            ["category_id" => 2, "description" => "Jumbo!", "weight" => 3520, "flavour" => "Chocolate", "price" => 20990, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 3520, "flavour" => "Vanilla", "price" => 20990, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 3520, "flavour" => "Strawberry", "price" => 20990, "created_at" => now(), "updated_at" => now()],

            ["category_id" => 2, "description" => "Jumbo!", "weight" => 6600, "flavour" => "Chocolate", "price" => 36790, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 6600, "flavour" => "Vanilla", "price" => 36790, "created_at" => now(), "updated_at" => now()],
            ["category_id" => 2, "description" => "Jumbo!", "weight" => 6600, "flavour" => "Strawberry", "price" => 36790, "created_at" => now(), "updated_at" => now()],
        ];

        if (!empty($allProducts)) {
            foreach (array_chunk($allProducts, 100) as $chunk) {
                DB::table('products')->insert($chunk);
            }
        }
        DB::table('products')->insert($jumboProducts);
        $this->command->info('Termékek sikeresen létrehozva!');
    }
}
