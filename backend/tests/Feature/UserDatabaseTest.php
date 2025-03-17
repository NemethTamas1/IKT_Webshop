<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserDatabaseTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_IsUsersTableEmpty()
    {
        $this->assertTrue(Schema::hasTable('users'), 'A users tábla nem jött létre.');
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
}
