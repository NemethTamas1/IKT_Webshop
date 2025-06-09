<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected $category;
    protected $brand;
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'id' => 1,
            'name' => 'TestCategory'
        ]);

        $this->brand = Brand::create([
            'id' => 1,
            'name' => 'TestBrand'
        ]);
    }
    public function test_admin_can_create_product()
    {
        $admin = User::create([
            "role" => "admin",
            "name" => "Admin2",
            "password" => Hash::make("Admin123456"),
            "email" => "admin2@test.com",
            "phone" => "0679873562",
            "country" => "Hungary",
            "city" => "Budapest",
            "zip" => "1163",
            "street_name" => "Petőfi",
            "street_type" => "utca",
            "street_number" => "11",
            "floor" => "Nincs"
        ]);

        $response = $this->actingAs($admin)->post('/api/products', [
            'category_id' => 1,
            'brand_id' => 1,
            'name' => 'Test Product',
            'slug' => 'Test_Product',
            'description' => 'Test Description',
            'product_line' => '1',
            'available' => 1,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }

    public function test_user_can_not_create_product()
    {
        $user = User::create([
            "role" => "user",
            "name" => "TestUser",
            "password" => Hash::make("TestUser123456"),
            "email" => "testuser@testemail.com",
            "phone" => "06207986654",
            "country" => "Hungary",
            "city" => "Budapest",
            "zip" => "1172",
            "street_name" => "Arany János",
            "street_type" => "utca",
            "street_number" => "20",
            "floor" => "Nincs"
        ]);

        $response = $this->actingAs($user)->post('/api/products', [
            'category_id' => 1,
            'brand_id' => 1,
            'name' => 'Test Product',
            'slug' => 'Test_Product',
            'description' => 'Test Description',
            'product_line' => '1',
            'available' => 1,
        ]);

        $response->assertStatus(403);
    }
}
