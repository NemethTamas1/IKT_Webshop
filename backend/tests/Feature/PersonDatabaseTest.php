<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PersonDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_IsUsersTableEmpty()
    {
        $this->assertTrue(Schema::hasTable('persons'), 'A users tábla nem jött létre.');
    }
    public function test_IsPersonsTableHasValidKeys()
    {
        $this->assertTrue(Schema::hasColumns('Persons', [
            'first_name',
            'last_name',
            'email',
            'phone',
            'password',
            'created_at',
            'updated_at',
        ]));
    }
    
    public function test_IsPersonsTableHasCorrectColumnValueTypes(){
       
        $columns = [
            'id' => 'bigint',
            'first_name' => 'varchar',
            'last_name' => 'varchar',
            'email' => 'varchar',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        foreach ($columns as $column => $type) {
            $this->assertTrue(
                Schema::hasColumn('tickets', $column),
                "A {$column} oszlop nem jött létre az `tickets` táblában."
            );

            $this->assertEquals(
                $type,
                Schema::getColumnType('tickets', $column),
                "A {$column} mező típusa nem egyezik az elvárt (migráció) típussal."
            );
        }
    }
}
