<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Orders_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_orders_table_has_created(): void
    {
        $this->assertTrue(
            Schema::hasTable('orders'),
            'Az `orders` tábla nem található az adatbázisban.'
        );
    }
    public function test_orders_table_has_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'id'),
            'Az id mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_user_id_foreign_key_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'user_id'),
            'A user_id mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_order_status_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'order_status'),
            'Az order_status mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_total_amount_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'total_amount'),
            'A `total_amount` mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_total_quantity_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'total_quantity'),
            'A total_quantity mező nem létezik a orders táblában'
        );
    }
    public function test_orders_table_has_created_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'created_at'),
            'A created_at mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_updated_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'updated_at'),
            'Az updated_at mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_deleted_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'deleted_at'),
            'A deleted_at mező nem létezik a orders táblában (softDeletes)'
        );
    }
    public function test_orders_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('orders', [
                'id',
                'user_id',
                'order_status',
                'total_amount',
                'total_quantity',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A orders tábla nem (helyesen) tartalmazza a szükséges oszlopokat'
        );
    }
}
