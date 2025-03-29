<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserDatabaseTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_users_table_exists()
    {
        $this->assertTrue(Schema::hasTable('users'), 'A users tábla nem létezik.');
    }
    public function test_users_table_is_empty_at_the_begining()
    {
        $this->assertEquals(0, DB::table('users')->count(), 'A users tábla nem üres alapértelmezetten.');
    }
    public function test_users_table_has_correct_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'role',
                'username',
                'user_password', 
                'email',
                'shipping_country',
                'shipping_city',
                'shipping_zip',
                'shipping_street',
                'shipping_street_numb',
                'bonus_credits',
                'created_at',
                'updated_at'
            ]),
            'Hiányzó vagy nem megfelelő oszlopok a táblában.'
        ) ;
        $this->assertEquals(
            count([
                'id',
                'role',
                'username',
                'user_password', 
                'email',
                'shipping_country',
                'shipping_city',
                'shipping_zip',
                'shipping_street',
                'shipping_street_numb',
                'bonus_credits',
                'created_at',
                'updated_at'
            ]),
            count(Schema::getColumnListing('users')),
            'Az oszlopok száma nem egyezik az elvártakkal!'
        );
    }
    public function test_IsPersonsTableHasValidKeys()
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id',
            'person_id',
            'user_name',
            'bonus_credits',
            'created_at',
            'updated_at',
        ]));
    }
    public function test_users_table_primary_key_is_id()
    {
        $keyName = DB::table('users')->getColumns()[0];
        $this->assertEquals('id', $keyName, 'Az `id` NEM elsődleges kulcs!');
    }
}
