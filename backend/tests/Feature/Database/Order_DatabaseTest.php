<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Order_DatabaseTest extends TestCase
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

    public function test_orders_table_has_shipping_email_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_email'),
            'A shipping_email mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_name_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_name'),
            'A shipping_name mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_phone_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_phone'),
            'A shipping_phone mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_country_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_country'),
            'A shipping_country mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_city_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_city'),
            'A shipping_city mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_zip_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_zip'),
            'A shipping_zip mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_street_name_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_street_name'),
            'A shipping_street_name mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_street_type_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_street_type'),
            'A shipping_street_type mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_shipping_street_number_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'shipping_street_number'),
            'A shipping_street_number mező nem létezik az orders táblában'
        );
    }

    public function test_orders_table_has_orderstatus_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'orderstatus'),
            'Az orderstatus mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_totalamount_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'totalamount'),
            'A `totalamount` mező nem létezik a orders táblában'
        );
    }

    public function test_orders_table_has_totalquantity_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('orders', 'totalquantity'),
            'A totalquantity mező nem létezik a orders táblában'
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
                'shipping_email',
                'shipping_name',
                'shipping_phone',
                'shipping_country',
                'shipping_city',
                'shipping_zip',
                'shipping_street_name',
                'shipping_street_type',
                'shipping_street_number',
                'orderstatus',
                'totalamount',
                'totalquantity',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A orders tábla nem (helyesen) tartalmazza a szükséges oszlopokat'
        );
    }
}
