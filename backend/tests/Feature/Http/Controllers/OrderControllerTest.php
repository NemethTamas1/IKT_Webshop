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
        $this->user = new User();
        $this->order = new Order();
        $this->baseURL = '/api/orders/';
        $this->testData = [
            "user_id" => 1,
            "orderstatus" => "pending", // ez lesz majd a default érték!
            "totalamount" => 36_500,
            "totalquantity" => 3,
        ];
    }

    public function test_can_create_an_order()
    {
        $response = $this->post($this->baseURL, $this->testData);

        $response->assertStatus(201);
    }
    public function test_created_order_is_not_empty()
    {
        $orderData = [
            "user_id" => 1,
            "orderstatus" => "pending",
            "totalamount" => 36_500,
            "totalquantity" => 3,
        ];

        $this->post($this->baseURL, $orderData);
        $this->assertDatabaseHas('orders', [
            "user_id" => 1,
            "orderstatus" => "pending",
            "totalamount" => 36_500,
            "totalquantity" => 3,
        ]);
    }
    public function test_order_requires_a_user_id()
    {
        $response = $this->post($this->baseURL, [
            // direkt nincs itt user_id!
            "orderstatus" => "pending",
            "totalamount" => 36_500,
            "totalquantity" => 3,
        ]);
        $response->assertStatus(302);
    }
    public function test_user_id_do_not_have_to_be_unique_to_create_in_database()
    {
        $this->testData = [
            'user_id' => 1,
            "orderstatus" => "pending",
            "totalamount" => 36_500,
            "totalquantity" => 3,
        ];
        $response = $this->postJson($this->baseURL, $this->testData);
        $response = $this->postJson($this->baseURL, $this->testData); // Direkt 2x ugyanazt!

        $response->assertStatus(201);
    }
    public function test_order_can_be_updated()
    {
        $this->postJson($this->baseURL, $this->testData);
        $order = Order::latest()->first();

        $updatedData = [
            'user_id' => $order->user_id,
            'orderstatus' => 'in_delivery',
            'totalamount' => 66666,
            'totalquantity' => 5,
        ];
        $this->putJson("{$this->baseURL}{$order->id}", $updatedData);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'orderstatus' => 'in_delivery',
            'totalamount' => 66666,
            'totalquantity' => 5
        ]);
    }

    public function test_total_quantity_cannot_exceed_maximum_of_50_pcs()
    {
        $invalidData = [
            "user_id" => 1,
            "orderstatus" => "in delivery",
            "totalamount" => 36500,
            "totalquantity" => 51,
        ];

        $this->postJson($this->baseURL, $invalidData)->assertStatus(422)->assertJsonValidationErrors('totalquantity');
    }

    public function test_order_can_be_soft_deleted_and_still_works()
    {
        $this->postJson($this->baseURL, $this->testData);

        $order = Order::latest()->first();
        $response = $this->delete("{$this->baseURL}{$order->id}");
        $response->assertStatus(204);
        
        $this->assertSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_deleted_order_still_exists_in_database()
    {
        $this->postJson($this->baseURL, $this->testData);

        $order = Order::latest()->first();
        $response = $this->delete("{$this->baseURL}{$order->id}");
        $response->assertStatus(204);

        $this->assertSoftDeleted('orders', ['id' => $order->id]);
    }
}
