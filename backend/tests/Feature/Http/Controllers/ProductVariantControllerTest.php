<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PhpParser\Node\Expr\Cast\Object_;
use Tests\TestCase;

class ProductVariantControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $baseURL;
    protected $brand;
    protected $category;
    protected $product;
    protected $baseData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpTestData();
    }

    private function setUpTestData(): void
    {
        $this->baseURL = '/api/productvariants/';

        $this->brand = Brand::create([
            "name" => "Base Brand",
            "description" => "Base brand description",
        ]);

        $this->category = Category::create([
            "name" => "Base Category",
            "description" => "Base category description",
        ]);

        $this->product = Product::create([
            'name' => 'Test_Product',
            'brand_id' => $this->brand->id,
            'category_id' => $this->category->id,
            'slug' => 'test-product-slug',
            'description' => 'Test product description',
            'product_line' => 'sample_line',
            'available' => true
        ]);

        $this->baseData = [
            "product_id" => $this->product->id,
            "quantity"   => 6,
            "unit"       => "kg",
            "flavour"    => "Csokoládé",
            "stock"      => 8,
            "price"      => 3200,
            "available"  => true,
            "image_path" => null
        ];
    }

    public function test_can_get_all_product_variants(): void
    {
        ProductVariant::create($this->baseData);
        $this->getJson($this->baseURL)
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_can_get_one_product_variant(): void
    {
        $variant = ProductVariant::create($this->baseData);
        $this->getJson($this->baseURL . $variant->id)
            ->assertStatus(200)
            ->assertJsonPath('data.id', $variant->id);
    }
    public function test_create_product_variant_returns_201_status(): void
    {
        $this->postJson($this->baseURL, $this->baseData)
            ->assertStatus(201)
            ->assertJsonPath('data.product_id', $this->product->id);
    }
    public function test_create_variant_requires_product_id(): void
    {
        $invalidData = $this->baseData;
        $invalidData['product_id'] = null;
        $this->postJson($this->baseURL, $invalidData)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_created_product_variant_is_in_database(): void
    {
        $this->postJson($this->baseURL, $this->baseData);
        $this->assertDatabaseHas('product_variants', [
            "product_id" => $this->product->id,
            "quantity"   => 6,
            "unit"       => "kg"
        ]);
    }
    public function test_create_variant_requires_quantity(): void
    {
        $invalidData = $this->baseData;
        $invalidData['quantity'] = null;
        $this->postJson($this->baseURL, $invalidData)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }
    public function test_can_update_product_variant_returns_200_status(): void
    {
        $variant = ProductVariant::create($this->baseData);
        $updated = $this->baseData;
        $updated['quantity'] = 77;
        $this->putJson($this->baseURL . $variant->id, $updated)->assertStatus(200);
    }

    public function test_update_validation_error_for_unit(): void
    {
        $variant = ProductVariant::create($this->baseData);
        $invalid = $this->baseData;
        $invalid['unit'] = '';
        $this->putJson($this->baseURL . $variant->id, $invalid)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['unit']);
    }

    public function test_can_delete_product_variant(): void
    {
        $variant = ProductVariant::create($this->baseData);
        $this->deleteJson($this->baseURL . $variant->id)
             ->assertStatus(204);
    }

    public function test_deleted_product_variant_is_soft_deleted(): void
    {
        $variant = ProductVariant::create($this->baseData);
        $this->deleteJson($this->baseURL . $variant->id);
        $this->assertSoftDeleted('product_variants', ['id' => $variant->id]);
    }

    public function test_cannot_update_nonexistent_product_variant(): void
    {
        $this->putJson($this->baseURL . '999999', $this->baseData)->assertStatus(404);
    }

    public function test_cannot_delete_nonexistent_product_variant(): void
    {
        $this->deleteJson($this->baseURL . '999999')
             ->assertStatus(404);
    }

    public function test_create_variant_requires_positive_stock(): void
    {
        $invalidData = $this->baseData;
        $invalidData['stock'] = -2;
        $this->postJson($this->baseURL, $invalidData)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['stock']);
    }

    public function test_create_variant_requires_positive_price(): void
    {
        $invalidData = $this->baseData;
        $invalidData['price'] = -1;
        $this->postJson($this->baseURL, $invalidData)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }

    public function test_create_variant_accepts_optional_flavour_and_image_path(): void
    {
        $optionalData = $this->baseData;
        $optionalData['flavour'] = null;
        $optionalData['image_path'] = null;
        $this->postJson($this->baseURL, $optionalData)
            ->assertStatus(201);
    }
}
