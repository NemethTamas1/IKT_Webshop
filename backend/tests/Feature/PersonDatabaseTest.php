<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_IsEmptyPersonDatabase(): void
    {
        $this->assertDatabaseEmpty('Persons');
    }
}
