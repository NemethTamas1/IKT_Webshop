<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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
        $this->baseURL = 'api/categories/';
        $this->baseData = [
            'name' => 'TestCategory_1',
            'brand' => 'TestProtein_1',
        ];
    }
    public function test_can_get_all_categories(): void
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
    public function test_can_get_one_category_data(): void
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
    public function test_can_create_category_data(): void
    {
        $data = [
            'name' => 'TestCategory',
            'brand' => 'TestProtein',
        ];
        $response = $this->postJson($this->baseURL, $data);
        $response->assertStatus(201);
    }
    public function test_can_modify_category_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $updateData = [
            'name' => 'TestCategory_2',
            "slug" => "teszt_slug_2",
            'brand' => 'TestProtein_2',
        ];
        $id = $response->json('data.id');
        $response = $this->put($this->baseURL . $id, $updateData);
        $response->assertStatus(200);
    }
    public function test_can_delete_category_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $id = $response->json('data.id');

        $response = $this->delete($this->baseURL . $id);
        $response->assertStatus(204);
    }
    public function test_category_can_be_soft_deleted_and_still_works()
    {
        $category = Category::create([
            "name" => "Base Category",
            "description" => "Base Category Description",
        ]);

        $this->delete($this->baseURL . $category->id)->assertStatus(204);
    }
    public function test_deleted_category_still_exists_in_database()
    {
        $category = Category::create([
            "name" => "Base Category",
            "description" => "Base Category Description",
        ]);

        $this->delete($this->baseURL . $category->id);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'deleted_at' => now()
        ]);
    }
    public function test_category_can_have_many_products()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            "name" => "Base Category",
            "description" => "Base Category Description",
        ]);


        Product::create([
            "name" => "Product 1",
            "brand_id" => $brand->id,
            "category_id" => $category->id,
            "slug" => "product_1_slug",
        ]);

        Product::create([
            "name" => "Product 2",
            "brand_id" => $brand->id,
            "category_id" => $category->id,
            "slug" => "product_2_slug",
        ]);

        $this->assertCount(2, $category->products);
    }
    public function test_category_have_many_products_and_Oneproduct_is_exists_in_database()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            "name" => "Base Category",
            "description" => "Base Category Description",
        ]);


        $product1 = Product::create([
            "name" => "Product 1",
            "brand_id" => $brand->id,
            "category_id" => $category->id,
            "slug" => "product_1_slug",
        ]);

        $this->assertTrue($category->products->contains($product1));
    }
    public function test_category_have_many_products_and_both_child_data_exist_in_database()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            "name" => "Base Category",
            "description" => "Base Category Description",
        ]);

        $product1 = Product::create([
            "name" => "Product 1",
            "brand_id" => $brand->id,
            "category_id" => $category->id,
            "slug" => "product_1_slug",
        ]);

        $product2 = Product::create([
            "name" => "Product 2",
            "category_id" => $category->id,
            "brand_id" => $brand->id,
            "slug" => "product_2_slug",
        ]);

        $this->assertTrue($category->products->contains($product1));
        $this->assertTrue($category->products->contains($product2));
    }
}
