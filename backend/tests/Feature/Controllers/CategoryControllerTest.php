<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions;
    // Osztály szinten deklarálom, így az összes 
    // metódusban ha kell csak behívjuk $this->baseURL -ként.
    // Figyeljetek, hogy ha X-edik elemet kérek le akkor (pont+idézőjelek között a számot adjuk át)
    // $this-baseURL.'1' -t kell írni!

    
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
            'category_name' => 'TestCategory_1',
            'brand' => 'TestProtein_1',
        ];
    }

    ////////////////////
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
            'category_name' => 'TestCategory',
            'brand' => 'TestProtein',
        ];
        $response = $this->postJson($this->baseURL, $data);
        $response->assertStatus(201);
    }
    public function test_can_modify_category_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $updateData = [
            'category_name' => 'TestCategory_2',
            'brand' => 'TestProtein_2',
        ];
        $id = $response->json('data.id');
        $response = $this->put($this->baseURL.$id, $updateData);
        $response->assertStatus(200);
    }
    public function test_can_delete_category_data(): void
    {
        $response = $this->postJson($this->baseURL, $this->baseData);
        $id = $response->json('data.id');

        $response = $this->delete($this->baseURL.$id);
        $response->assertStatus(204);
    }
}
