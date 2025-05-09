<?php

namespace Tests\Feature\Database;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoryDatabaseTest extends TestCase
{
    //      ! ! !       \\
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
        $this->assertTrue(Schema::hasColumn('categories', 'id'), 'Az id mező nem létezik a categories táblában');
    }

    public function test_categories_table_has_category_name_column(): void
    {
        $this->assertTrue(Schema::hasColumn('categories', 'category_name'), 'A category_name mező nem létezik a categories táblában');
    }

    public function test_categories_table_has_brand_column(): void
    {
        $this->assertTrue(Schema::hasColumn('categories', 'brand'), 'A brand mező nem létezik a categories táblában');
    }

    public function test_categories_table_has_created_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('categories', 'created_at'), 'A created_at mező nem létezik a categories táblában');
    }

    public function test_categories_table_has_updated_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('categories', 'updated_at'), 'Az updated_at mező nem létezik a categories táblában');
    }

    public function test_categories_table_has_deleted_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('categories', 'deleted_at'), 'A deleted_at mező nem létezik a categories táblában (softDeletes)');
    }

    // összes egyben
    public function test_categories_table_has_correct_column_names(): void
    {
        $this->assertTrue(
            Schema::hasColumns('categories', [
                'id',
                'category_name',
                'brand',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            //  else >>
            'A categories tábla nem tartalmazza a szükséges oszlopokat'
        );
    }
}
