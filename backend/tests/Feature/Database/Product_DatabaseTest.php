<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Product_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_products_table_has_created(): void
    {
        $this->assertTrue(
            Schema::hasTable('products'),
            'A products tábla nem található az adatbázisban'
        );
    }
    public function test_products_table_has_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'id'),
            'Az id mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_name_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'name'),
            'A name mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_brand_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'brand_id'),
            'A brand_id mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_category_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'category_id'),
            'A category_id mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_slug_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'slug'),
            'A slug mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_description_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'description'),
            'A description mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_product_line_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'product_line'),
            'A product_line mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_available_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'available'),
            'Az available mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_created_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'created_at'),
            'A created_at mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_updated_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'updated_at'),
            'Az updated_at mező nem létezik a products táblában'
        );
    }

    public function test_products_table_has_deleted_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'deleted_at'),
            'A deleted_at mező nem létezik a products táblában (softDeletes)'
        );
    }
    public function test_products_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'id',
                'name',
                'brand_id',
                'category_id',
                'slug',
                'description',
                'product_line',
                'available',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A products tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
    public function test_products_table_has_foreign_key_to_brands(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'brand_id'),
            'A products táblának nincs brand_id külső kulcsa'
        );
    }

    public function test_products_table_has_foreign_key_to_categories(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'category_id'),
            'A products táblának nincs category_id külső kulcsa'
        );
    }
}
