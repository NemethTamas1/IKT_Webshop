<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductAuthorizationTest extends TestCase
{
    use DatabaseTransactions;
    protected $category;
    protected $brand;
    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'id' => 99,
            'name' => 'TestCategory'
        ]);

        $this->brand = Brand::create([
            'id' => 99,
            'name' => 'TestBrand'
        ]);
        $this->admin = User::create([
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
        $this->user = User::create([
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
    }
    public function test_admin_can_create_product()
    {
        $response = $this->actingAs($this->admin)->post('/api/products', [
            'category_id' => 99,
            'brand_id' => 99,
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

        $response = $this->actingAs($this->user)->post('/api/products', [
            'category_id' => 99,
            'brand_id' => 99,
            'name' => 'Test Product',
            'slug' => 'Test_Product',
            'description' => 'Test Description',
            'product_line' => '1',
            'available' => 1,
        ]);

        $response->assertStatus(403);
    }
}
