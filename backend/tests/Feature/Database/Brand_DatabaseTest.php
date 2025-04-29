<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Brand_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_brands_table_has_created(): void
    {
        $this->assertTrue(
            Schema::hasTable('brands'),
            'A brands tábla nem található az adatbázisban'
        );
    }
    public function test_brands_table_has_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'id'),
            'Az id mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_name_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'name'),
            'A name mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_slug_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'slug'),
            'A slug mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_logo_path_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'logo_path'),
            'A logo_path mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_description_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'description'),
            'A description mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_created_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'created_at'),
            'A created_at mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_updated_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'updated_at'),
            'Az updated_at mező nem létezik a brands táblában'
        );
    }

    public function test_brands_table_has_deleted_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('brands', 'deleted_at'),
            'A deleted_at mező nem létezik a brands táblában (softDeletes)'
        );
    }
    public function test_brands_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('brands', [
                'id',
                'name',
                'slug',
                'logo_path',
                'description',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A brands tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
}