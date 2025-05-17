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
        $this->assertTrue(Schema::hasTable('users'), 'A `users` tábla nem található az adatbázisban.');
    }

    public function test_user_table_has_id_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'id'), 'Az `id` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_role_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'role'), 'A `role` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_username_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'username'), 'A `username` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_password_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'password'), 'A `password` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_email_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'email'), 'Az `email` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_email_verified_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'email_verified_at'), 'Az `email_verified_at` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_shipping_columns(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'street_name'), 'A `street_name` mező nem található a `users` táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'street_type'), 'A `street_type` mező nem található a `users` táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'street_number'), 'A `street_number` mező nem található a `users` táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'floor'), 'A `floor` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_timestamps(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'created_at'), 'A `created_at` mező nem található a `users` táblában.');
        $this->assertTrue(Schema::hasColumn('users', 'updated_at'), 'Az `updated_at` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_deleted_at_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'deleted_at'), 'A `deleted_at` mező nem található a `users` táblában.');
    }

    public function test_user_table_has_required_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'role',
                'username',
                'name',
                'password',
                'email',
                'phone',
                'country',
                'city',
                'zip',
                'street_name',
                'street_type',
                'street_number',
                'floor',
                'created_at',
                'updated_at',
                'deleted_at'
            ]),
            'A `users` tábla nem tartalmaz minden szükséges oszlopot.'
        );
    }
}
