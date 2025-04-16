<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_can_get_all_categories(): void
    {
        $response = $this->get('/api/categories');
        $response->assertStatus(200);

        $data = $response->json('data');

        $response = $this->assertNotEmpty($data);
    }
}
