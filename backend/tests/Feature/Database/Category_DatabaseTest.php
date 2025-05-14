<?php

namespace Tests\Feature\Database;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class Category_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_categories_table_has_created(): void
    {
        $this->assertTrue(
            Schema::hasTable('categories'),
            'A categories tábla nem található az adatbázisban'
        );
    }

    public function test_categories_table_has_id_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'id'),
            'Az id mező nem létezik a categories táblában'
        );
    }

    public function test_categories_table_has_name_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'name'),
            'A name mező nem létezik a categories táblában'
        );
    }

    public function test_categories_table_has_description_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'description'),
            'A description mező nem létezik a categories táblában'
        );
    }

    public function test_categories_table_has_created_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'created_at'),
            'A created_at mező nem létezik a categories táblában'
        );
    }

    public function test_categories_table_has_updated_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'updated_at'),
            'Az updated_at mező nem létezik a categories táblában'
        );
    }

    public function test_categories_table_has_deleted_at_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('categories', 'deleted_at'),
            'A deleted_at mező nem létezik a categories táblában (softDeletes)'
        );
    }

    public function test_categories_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('categories', [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A categories tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
}
