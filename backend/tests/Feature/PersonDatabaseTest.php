<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PersonDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_IsEmptyPersonDatabase(): void
    {
        $this->assertDatabaseEmpty('Persons');
    }
    use RefreshDatabase;

    public function test_IsEmptyPersonsDatabaseTable(): void
    {
        $this->assertDatabaseEmpty('Persons');
    }

    public function test_IsPersonsTableHasValidKeys(){
        $this->assertTrue(Schema::hasColumns('Persons', [
            'firstname',
            'lastname',
            'email',
            'phone',
            'password',
            'created_at',
            'updated_at',
        ]));
    }
}
