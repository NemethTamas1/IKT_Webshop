<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $baseURL;
    protected $baseData;
    protected $brand;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupTestData();
    }

    private function setupTestData(): void
    {
        $this->baseURL = '/api/products/';

        $this->category = Category::create([
            'name' => 'test_category',
            'description' => 'test_category_description'
        ]);

        $this->brand = Brand::create([
            'name' => 'test_brand',
            'description' => 'test_brand_description'
        ]);

        $this->baseData = [
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Test Product',
            'slug' => Str::slug('Test Product'),
            'description' => 'test_description',
            'product_line' => 'test_product_line',
            'available' => 1
        ];
    }

    public function test_can_get_one_product(): void
    {
        $product = Product::create($this->baseData);
        $response = $this->getJson($this->baseURL . $product->id);
        $response->assertStatus(200);
    }

    public function test_create_product_validation(): void
    {
        $invalidData = [
            'category_id' => 999999,
            'brand_id' => 999999,
            'name' => '',
            'slug' => '',
            'description' => '',
            'product_line' => ''
        ];
        $response = $this->postJson($this->baseURL, $invalidData);
        $response->assertStatus(422);
    }

    public function test_create_product_validation_errors(): void
    {
        $invalidData = [
            'category_id' => 999999,
            'brand_id' => 999999,
            'name' => '',
            'slug' => '',
            'description' => '',
            'product_line' => ''
        ];
        $response = $this->postJson($this->baseURL, $invalidData);
        $response->assertJsonValidationErrors([
            'category_id',
            'brand_id',
            'name',
            'description',
            'product_line'
        ]);
    }

    public function test_can_create_product(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $response->assertStatus(201);
    }

    public function test_created_product_has_correct_data(): void
    {
        $this->postJson($this->baseURL, $this->baseData);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'description' => 'test_description'
        ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::create($this->baseData);
        $updatedData = [
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Updated Product Name',
            'slug' => Str::slug('Updated Product Name'),
            'description' => 'updated_description',
            'product_line' => 'updated_product_line',
            'available' => 0
        ];
        $response = $this->putJson($this->baseURL . $product->id, $updatedData);
        $response->assertStatus(200);
    }

    public function test_updated_product_has_correct_data(): void
    {
        $product = Product::create($this->baseData);
        $updatedData = [
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'name' => 'Updated Product Name',
            'slug' => Str::slug('Updated Product Name'),
            'description' => 'updated_description',
            'product_line' => 'updated_product_line',
            'available' => 0
        ];
        $this->putJson($this->baseURL . $product->id, $updatedData);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'description' => 'updated_description'
        ]);
    }

    public function test_update_product_validation(): void
    {
        $product = Product::create($this->baseData);
        $invalidData = [
            'category_id' => 999999,
            'brand_id' => 999999,
            'name' => '',
            'slug' => '',
            'description' => '',
            'product_line' => ''
        ];
        $response = $this->putJson($this->baseURL . $product->id, $invalidData);
        $response->assertStatus(422);
    }

    public function test_update_product_validation_errors(): void
    {
        $product = Product::create($this->baseData);
        $invalidData = [
            'category_id' => 999999,
            'brand_id' => 999999,
            'name' => '',
            'slug' => '',
            'description' => '',
            'product_line' => ''
        ];
        $response = $this->putJson($this->baseURL . $product->id, $invalidData);
        $response->assertJsonValidationErrors([
            'category_id',
            'brand_id',
            'name',
            'description',
            'product_line'
        ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create($this->baseData);
        $response = $this->deleteJson($this->baseURL . $product->id);
        $response->assertStatus(204);
    }

    public function test_deleted_product_is_soft_deleted(): void
    {
        $product = Product::create($this->baseData);
        $this->deleteJson($this->baseURL . $product->id);
        $this->assertSoftDeleted('products', [
            'id' => $product->id
        ]);
    }

    public function test_cannot_update_nonexistent_product(): void
    {
        $nonexistentId = 99999;
        $response = $this->putJson($this->baseURL . $nonexistentId, $this->baseData);
        $response->assertStatus(404);
    }

    public function test_cannot_delete_nonexistent_product(): void
    {
        $nonexistentId = 99999;
        $response = $this->deleteJson($this->baseURL . $nonexistentId);
        $response->assertStatus(404);
    }
}