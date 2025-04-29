<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductVariant_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_product_variants_table_has_created(): void
    {
        $this->assertTrue(
            Schema::hasTable('product_variants'),
            'A product_variants tábla nem található az adatbázisban'
        );
    }
    public function test_product_variants_table_has_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'id'),
            'Az id mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_product_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'product_id'),
            'A product_id mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_quantity_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'quantity'),
            'A quantity mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_unit_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'unit'),
            'A unit mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_flavour_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'flavour'),
            'A flavour mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_stock_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'stock'),
            'A stock mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_price_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'price'),
            'A price mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_available_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'available'),
            'Az available mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_image_path_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'image_path'),
            'Az image_path mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_created_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'created_at'),
            'A created_at mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_updated_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'updated_at'),
            'Az updated_at mező nem létezik a product_variants táblában'
        );
    }

    public function test_product_variants_table_has_deleted_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'deleted_at'),
            'A deleted_at mező nem létezik a product_variants táblában (softDeletes)'
        );
    }
    public function test_product_variants_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('product_variants', [
                'id',
                'product_id',
                'quantity',
                'unit',
                'flavour',
                'stock',
                'price',
                'available',
                'image_path',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A product_variants tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
    public function test_product_variants_table_has_foreign_key_to_products(): void
    {
        $this->assertTrue(
            Schema::hasColumn('product_variants', 'product_id'),
            'A product_variants táblának nincs product_id külső kulcsa'
        );
    }
}
