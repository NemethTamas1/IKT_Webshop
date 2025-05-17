<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $order;
    protected $baseURL;
    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->order = new Order();
        $this->baseURL = '/api/orders/';
        $this->testData = [
            "user_id" => $this->user->id,
            "orderstatus" => "pending", // ez lesz majd a default érték!
            "totalamount" => 36500,
            "totalquantity" => 3,
            "shipping_email" => "test@example.com",
            "shipping_name" => "Test User",
            "shipping_phone" => "+36123456789",
            "shipping_country" => "Hungary",
            "shipping_city" => "Budapest",
            "shipping_zip" => "1234",
            "shipping_street_name" => "Test Street",
            "shipping_street_type" => "Road",
            "shipping_street_number" => "10",
            "shipping_floor" => "1/30"
        ];
    }

    public function test_can_create_an_order()
    {
        $response = $this->postJson($this->baseURL, $this->testData);

        $response->assertStatus(201);
    }

    public function test_created_order_is_not_empty()
    {
        $this->postJson($this->baseURL, $this->testData);
        $order = Order::latest()->first();

        $this->assertNotNull($order);
    }

    public function test_order_requires_a_user_id_or_guest_data()
    {
        $guestData = $this->testData;
        unset($guestData["user_id"]);

        $this->postJson($this->baseURL, $guestData)->assertStatus(201);
    }

    public function test_user_id_do_not_have_to_be_unique_to_create_in_database()
    {
        $this->postJson($this->baseURL, $this->testData);
        $response = $this->postJson($this->baseURL, $this->testData); // Ugyanaz a user_id kétszer

        $response->assertStatus(201);
    }

    public function test_order_can_be_updated()
    {
        $response = $this->postJson($this->baseURL, $this->testData);
        $responseData = json_decode($response->getContent(), true);
        $orderId = $responseData['data']['id'];

        $updatedData = [
            'orderstatus' => 'shipped',
            'totalamount' => 50000,
            'totalquantity' => 5,
            'shipping_city' => 'Debrecen',
            'shipping_zip' => '4031'
        ];

        $updateResponse = $this->putJson("{$this->baseURL}{$orderId}", $updatedData);
        $updateResponse->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $orderId,
            'orderstatus' => 'shipped',
            'totalamount' => 50000,
            'totalquantity' => 5,
            'shipping_city' => 'Debrecen',
            'shipping_zip' => '4031'
        ]);
    }

    public function test_total_quantity_cannot_exceed_maximum_of_50_pcs()
    {
        $invalidData = $this->testData;
        $invalidData['totalquantity'] = 51;

        $this->postJson($this->baseURL, $invalidData)
            ->assertStatus(422)
            ->assertJsonValidationErrors('totalquantity');
    }

    public function test_order_can_be_soft_deleted_and_still_works()
    {
        $response = $this->postJson($this->baseURL, $this->testData);
        $responseData = json_decode($response->getContent(), true);
        $orderId = $responseData['data']['id'];

        $deleteResponse = $this->delete("{$this->baseURL}{$orderId}");
        $deleteResponse->assertStatus(204);

        $this->assertSoftDeleted('orders', ['id' => $orderId]);
    }

    public function test_deleted_order_still_exists_in_database()
    {
        $response = $this->postJson($this->baseURL, $this->testData);
        $responseData = json_decode($response->getContent(), true);
        $orderId = $responseData['data']['id'];

        $this->delete("{$this->baseURL}{$orderId}");

        $this->assertDatabaseHas('orders', ['id' => $orderId]);
        $this->assertSoftDeleted('orders', ['id' => $orderId]);
    }
}
