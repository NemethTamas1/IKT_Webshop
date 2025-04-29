<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class ProductVariantControllerTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
