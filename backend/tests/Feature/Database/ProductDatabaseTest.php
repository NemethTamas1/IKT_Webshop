<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductDatabaseTest extends TestCase
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
        $this->assertTrue(Schema::hasColumn('products', 'id'), 'Az id mező nem létezik a products táblában');
    }

    public function test_products_table_has_category_id_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'category_id'), 'A category_id mező nem létezik a products táblában');
    }

    public function test_products_table_has_description_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'description'), 'A description mező nem létezik a products táblában');
    }

    public function test_products_table_has_weight_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'quantity'), 'A quantity mező nem létezik a products táblában');
    }

    public function test_products_table_has_flavour_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'flavour'), 'A flavour mező nem létezik a products táblában');
    }

    public function test_products_table_has_price_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'price'), 'A price mező nem létezik a products táblában');
    }

    public function test_products_table_has_created_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'created_at'), 'A created_at mező nem létezik a products táblában');
    }

    public function test_products_table_has_updated_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'updated_at'), 'Az updated_at mező nem létezik a products táblában');
    }

    public function test_products_table_has_deleted_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('products', 'deleted_at'), 'A deleted_at mező nem létezik a products táblában (softDeletes)');
    }

    public function test_products_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'id',
                'category_id',
                'description',
                'quantity',
                'flavour',
                'price',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A products tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
}
