<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class User_DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('users'), 'A users tábla nem található az adatbázisban.');
    }

    public function test_user_table_has_id_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'id'), 'Az id mező nem létezik a users táblában.');
    }

    public function test_user_table_has_role_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'role'), 'A role mező nem létezik a users táblában.');
    }

    public function test_user_table_has_username_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'username'), 'A username mező nem létezik a users táblában.');
    }

    public function test_user_table_has_password_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'password'), 'A password mező nem létezik a users táblában.');
    }

    public function test_user_table_has_email_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'email'), 'Az email mező nem létezik a users táblában.');
    }

    public function test_user_table_has_email_verified_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'email_verified_at'), 'Az email_verified_at mező nem létezik a users táblában.');
    }

    public function test_user_table_has_shipping_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'shipping_country'), 'A shipping_country mező nem létezik a users táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'shipping_city'), 'A shipping_city mező nem létezik a users táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'shipping_zip'), 'A shipping_zip mező nem létezik a users táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'shipping_street'), 'A shipping_street mező nem létezik a users táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'shipping_street_number'), 'A shipping_street_number mező nem létezik a users táblában.');
    }

    public function test_user_table_has_timestamps(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'created_at'), 'A created_at mező nem létezik a users táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'updated_at'), 'Az updated_at mező nem létezik a users táblában.');
    }

    public function test_user_table_has_deleted_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'deleted_at'), 'A deleted_at mező nem létezik a users táblában (softDeletes).');
    }

    public function test_user_table_has_required_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'role',
                'username',
                'password',
                'email',
                'email_verified_at',
                'shipping_country',
                'shipping_city',
                'shipping_zip',
                'shipping_street',
                'shipping_street_number',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A users tábla nem (helyesen) tartalmazza a szükséges oszlopokat.'
        );
    }
}
