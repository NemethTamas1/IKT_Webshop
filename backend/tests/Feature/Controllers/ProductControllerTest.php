<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $baseURL;
    protected $baseData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupTestData();
    }

    private function setupTestData(): void
    {
        $this->baseURL = 'api/products/';
    
        $category = Category::create([
            'category_name' => 'test_category',
            'brand' => 'test_brand',
        ]);
    
        $this->baseData = [
            'category_id' => $category->id,
            'description' => 'test_description',
            'quantity' => 666,
            'flavour' => 'test_flavour',
            'price' => 666,
            'categories' => [
                "brand" => "test_brand",
                "category_name" => "test_category",
                "stock" => 66,
                "available" => 1,
            ],
        ];
    }

    public function test_can_get_all_products(): void
    {
        $response = $this->get($this->baseURL);
        $response->assertStatus(200);

        $response->json('data');
    }
    public function test_gotten_data_has_not_empty(): void
    {
        $response = $this->get($this->baseURL);
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }
    public function test_can_get_one_product_data(): void
    {
        $response = $this->get($this->baseURL . '1');
        $response->assertStatus(200);
    }
    public function test_gotten_one_object_data_has_not_empty(): void
    {
        $response = $this->get($this->baseURL . '1');
        $data = $response->json('data');
        $this->assertNotEmpty($data);
    }
    public function test_can_create_product_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $response->assertStatus(201);
    }
    public function test_can_modify_product_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $updateData = [
            'category_id' => 1,
            'description' => 'test_description_modified',
            'quantity' => 555,
            'flavour' => 'test_flavour_modified',
            'price' => 555,
        ];
        $id = $response->json('data.id');
        $response = $this->put($this->baseURL.$id, $updateData);
        $response->assertStatus(200);
    }
    public function test_can_delete_product_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $id = $response->json('data.id');

        $response = $this->delete($this->baseURL.$id);
        $response->assertStatus(204);
    }
}
