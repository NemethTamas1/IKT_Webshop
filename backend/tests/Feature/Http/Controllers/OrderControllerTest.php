<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
        $this->testOrder = [
            "user_id" => 666,
            "order_status" => "pending", // ez lesz majd a default érték!
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ];
    }

    public function test_can_create_an_order()
    {
        $data = $this->testData;

        $response = $this->post($this->baseURL, $data);

        $response->assertStatus(201);
    }
    public function test_created_order_is_not_empty()
    {
        $orderData = [
            "user_id" => 666,
            "order_status" => "pending",
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ];

        $this->post($this->baseURL, $orderData);
        $this->assertDatabaseHas('orders', [
            "order_status" => "pending",
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ]);
    }
    public function test_order_requires_a_user_id()
    {
        $response = $this->post($this->baseURL, [
            // direkt nincs itt user_id!
            "order_status" => "pending",
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ]);
        $response->assertStatus(302);
    }
    public function test_user_id_do_not_have_to_be_unique_to_create_in_database()
    {
        $this->testData = [
            'user_id' => 1,
            "order_status" => "pending",
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ];
        $response = $this->post($this->baseURL, $this->testData);
        $response = $this->post($this->baseURL, $this->testData); // Direkt 2x ugyanazt!

        $response->assertStatus(201);
    }
    public function test_order_can_be_updated()
    {
        $order = $this->testData;

        $updatedData = [
            'user_id' => $order->id,
            "order_status" => "in delivery",
            "total_amount" => 36_500,
            "total_quantity" => 3,
        ];

        $this->putJson($this->baseURL . $order->id, $updatedData)->assertStatus(200);
    }

    public function test_total_quantity_cannot_exceed_maximum_of_50_pcs()
    {
        $invalidData = [
            "id" => 1,
            "user_id" => 1,
            "order_status" => "in delivery",
            "total_amount" => 36_500,
            "total_quantity" => 51,
        ];

        $this->putJson($this->baseURL . 1, $invalidData)->assertStatus(302);
    }

    public function test_a_order_can_be_soft_deleted_and_still_works()
    {
        $order = Order::create([
            "id" => 1,
            "user_id" => 1,
        ]);
        $this->delete($this->baseURL . $order->id)->assertStatus(204);
    }

    public function test_deleted_order_still_exists_in_database()
    {
        $order = Order::create([
            "id" => 1,
            "user_id" => 1,
        ]);

        $this->delete($this->baseURL . $order->id);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'deleted_at' => now()
        ]);
    }
}
