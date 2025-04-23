<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        // Termékek lekérése DB-ből (egyelőre így jó lesz!)
        $wppProduct = Product::where('name', '100% Whey Protein Professional')->first();
        $jumboProduct = Product::where('name', 'Jumbo!')->first();
        $megaDailyOne = Product::where('name', 'Mega Daily One')->first();
        $multiProPlus = Product::where('name', 'Multi Pro Plus')->first();
        $calciumMagnesium = Product::where('name', 'Calcium Magnesium')->first();
        $builderWhey = Product::where('name', 'Whey Protein')->first();
        $Cvitamin = Product::where('name', 'C vitamin')->first();
        $vitaDay = Product::where('name', 'Vitaday')->first();
        $vitaProPack = Product::where('name', 'Vitapro Pack')->first();
        $proWhey = Product::where('name', 'Pro Whey')->first();
        $dailyHealthCompley = Product::where('name', 'Daily Health - Komplex')->first();
        $dailyHealthCvitamin = Product::where('name', 'Daily Health - C Vitamin')->first();

        // Variánsok 
        $variants = [
            // Scitec 100% WPP
            $wppProduct?->id => [
                'quantities' => [
                    30 => 490,
                    500 => 5510,
                    920 => 12490,
                    2350 => 25990,
                    5000 => 49990
                ],
                'unit' => 'gr',
                'flavours' => [
                    'standard' => [
                        'Vanilla', 'Chocolate', 'Strawberry', 'Chocolate-Nuts',
                        'Strawberry-WhiteChoco', 'Chocolate-Coconut', 'Chocolate-Cookie',
                        'Banana', 'Kiwi-Banana', 'Coconut', 'Lemon-Cheesecake',
                        'Vanilla-Raspberries', 'Ice-Coffe', 'Peanut-Butter',
                        'Salted-Caramel', 'White-Chocolate', 'Pistachio-White Chocolate'
                    ],
                    // 5000g-os kiszerelésben az elérhető ízek
                    5000 => [
                        'Chocolate-Cookie', 'Lemon-Cheesecake', 'Chocolate', 'Vanilla',
                        'Chocolate-Nuts', 'Strawberry-WhiteChoco', 'Chocolate-Coconut',
                        'Banana', 'Vanilla-Raspberries', 'Strawberry'
                    ]
                ]
            ],

            // Scitec Jumbo! 
            $jumboProduct?->id => [
                'quantities' => [
                    1320 => 10490,
                    3520 => 20990,
                    6600 => 36790
                ],
                'unit' => 'gr',
                'flavours' => [
                    'standard' => [
                        'Chocolate', 'Vanilla', 'Strawberry', 'Banana'
                    ]
                ]
            ],

            // Calcium Magnesium - nincs íz
            $calciumMagnesium?->id => [
                'quantities' => [
                    90 => 4190,    // 90 tabi
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Mega Daily One 
            $megaDailyOne?->id => [
                'quantities' => [
                    60 => 3890,
                    120 => 6490
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Multi Pro Plus 
            $multiProPlus?->id => [
                'quantities' => [
                    60 => 10490,
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Builder WheyProtein 
            $builderWhey?->id => [
                'quantities' => [
                    28 => 290,
                    1000 => 7190,
                    4000 => 25880
                ],
                'unit' => 'gr',
                'flavours' => [
                    'standard' => [
                        'Vanilla', 'Chocolate', 'Black Raspberry-White Chocolate',
                        'Cookies And Cream'
                    ]
                ]
            ],

            // Pro Nutrition - Pro Whey
            $proWhey?->id => [
                'quantities' => [
                    900 => 11390,
                    2000 => 22290,
                    4000 => 39790
                ],
                'unit' => 'gr',
                'flavours' => [
                    'standard' => [
                        'Vanilla', 'Chocolate', 'Strawberry'
                    ]
                ]
            ],

            // C vitamin - Sciteces
            $Cvitamin?->id => [
                'quantities' => [
                    100 => 2990,
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Vitaday 
            $vitaDay?->id => [
                'quantities' => [
                    60 => 1990,
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Vitapro Pack 
            $vitaProPack?->id => [
                'quantities' => [
                    30 => 7990,
                ],
                'unit' => 'csomag',
                'no_flavour' => true
            ],

            // Daily Health - Komplex 
            $dailyHealthCompley?->id => [
                'quantities' => [
                    60 => 4490,
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],

            // Daily Health - C Vitamin 
            $dailyHealthCvitamin?->id => [
                'quantities' => [
                    90 => 2690,
                ],
                'unit' => 'tab.',
                'no_flavour' => true
            ],
        ];

        foreach ($variants as $productId => $variantData) {
            // Ha a termék nem létezik
            if (!$productId) continue;

            foreach ($variantData['quantities'] as $quantity => $price) {
                // Ha nincs íz
                if (isset($variantData['no_flavour']) && $variantData['no_flavour']) {
                    DB::table('product_variants')->insert([
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'flavour' => null,
                        'price' => $price,
                        'stock' => 5,
                        'available' => true,
                        'unit' => $variantData['unit'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } 
                // Ha van íz
                else {
                    $flavours = isset($variantData['flavours'][$quantity])
                        ? $variantData['flavours'][$quantity]
                        : $variantData['flavours']['standard'];

                    foreach ($flavours as $flavour) {
                        DB::table('product_variants')->insert([
                            'product_id' => $productId,
                            'quantity' => $quantity,
                            'flavour' => $flavour,
                            'price' => $price,
                            'stock' => 5,
                            'available' => true,
                            'unit' => $variantData['unit'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }

        $this->command->info('Termék variánsok sikeresen létrehozva!');
    }
}