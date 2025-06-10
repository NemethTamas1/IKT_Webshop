<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $brand;
    protected $baseURL;
    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->brand = new Brand();
        $this->baseURL = '/api/brands/';
        $this->testData = [
            "id" => 666,
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ];
    }

    public function test_can_create_a_brand()
    {
        $response = $this->post($this->baseURL, $this->testData);

        $response->assertStatus(201);
    }
    public function test_created_brand_is_not_empty()
    {
        $brandData = [
            'name' => 'Test Brand',
            'description' => 'Test Brand Description',
        ];

        $this->post($this->baseURL, $brandData);
        $this->assertDatabaseHas('brands', ['name' => 'Test Brand']);
    }
    public function test_brand_requires_a_name()
    {
        $response = $this->post($this->baseURL, [
            'description' => 'Test Description'
        ]);
        $response->assertStatus(302);
    }
    public function test_brand_name_must_be_unique_to_create_in_database()
    {
        $this->testData = [
            'name' => 'Test Brand',
            'description' => 'Test Brand Description',
        ];
        $response = $this->post($this->baseURL, $this->testData);
        $response = $this->post($this->baseURL, $this->testData);

        $response->assertStatus(302);
    }
    public function test_brand_can_be_updated()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $updatedData = [
            "name" => "Updated Brand",
            "description" => "Updated Description",
        ];

        $this->putJson($this->baseURL . $brand->id, $updatedData)->assertStatus(200);
    }

    public function test_brand_name_length_cannot_exceed_50_characters()
    {
        $longName = str_repeat('a', 51);

        $this->postJson(($this->baseURL . $this->brand->id), [
            'name' => $longName
        ])->assertStatus(422);
    }

    public function test_a_brand_can_be_soft_deleted_and_still_works()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);
        $this->delete($this->baseURL . $brand->id)->assertStatus(204);
    }

    public function test_deleted_brand_still_exists_in_database()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $this->delete($this->baseURL . $brand->id);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
            'deleted_at' => now()
        ]);
    }
    public function test_brand_can_have_many_products()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            'name' => 'Test Category',
        ]);

        Product::create([
            'name' => 'Product 1',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'slug' => 'product_test_slug',
        ]);

        Product::create([
            'name' => 'Product 2',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'slug' => 'product_test_slug_2',


        ]);
        $this->assertCount(2, $brand->products);
    }
    public function test_brand_have_many_products_and_productOne_is_exists_in_database()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $product1 = Product::create([
            'name' => 'Product 1',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'slug' => 'product_test_slug_3',

        ]);
        $this->assertTrue($brand->products->contains($product1));
    }
    public function test_brand_have_many_products_and_both_child_data_are_exists_in_database()
    {
        $brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base_Updated Description",
        ]);

        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $product1 = Product::create([
            'name' => 'Product 1',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'slug' => 'product_test_slug_4',
        ]);

        $product2 = Product::create([
            'name' => 'Product 2',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'slug' => 'product_test_slug_5',
        ]);
        $this->assertTrue($brand->products->contains($product1), $brand->products->contains($product2), 'Some data is missing');
    }
}
