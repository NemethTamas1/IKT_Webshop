<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
            'slug' => 'test-product',
            'description' => 'test_description',
            'product_line' => 'test_product_line',
            'available' => 1
        ];
    }

    public function test_can_get_one_product(): void
    {
        $product = Product::create($this->baseData);
        $this->getJson($this->baseURL . $product->id)->assertStatus(200);
    }

    public function test_create_product_returns_403_status_by_user_modifications(): void
    {
        $this->postJson($this->baseURL, $this->baseData)->assertStatus(403);
    }

    public function test_create_product_requires_name(): void
    {
        $invalidData = $this->baseData;
        $invalidData['name'] = '';

        $this->postJson($this->baseURL, $invalidData)->assertStatus(403);
    }

    public function test_can_update_product_returns_200_status(): void
    {
        $product = Product::create($this->baseData);

        $updatedData = $this->baseData;
        $updatedData['name'] = 'Updated Product';

        $response = $this->putJson($this->baseURL . $product->id, $updatedData);
        $response->assertStatus(200);
    }

    public function update_product_validation_error_for_name(): void
    {
        $product = Product::create($this->baseData);

        $invalidData = $this->baseData;
        $invalidData['name'] = '';

        $this->putJson($this->baseURL . $product->id, $invalidData)->assertJsonValidationErrors(['name']);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::create($this->baseData);

        $this->deleteJson($this->baseURL . $product->id)->assertStatus(204);
    }

    public function test_deleted_product_is_soft_deleted(): void
    {
        $product = Product::create($this->baseData);

        $this->deleteJson($this->baseURL . $product->id);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_cannot_update_nonexistent_product(): void
    {
        $this->putJson($this->baseURL . '99999', $this->baseData)->assertStatus(404);
    }

    public function test_cannot_delete_nonexistent_product(): void
    {
        $this->deleteJson($this->baseURL . '99999')->assertStatus(404);
    }
}
