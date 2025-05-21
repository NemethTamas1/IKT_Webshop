<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $order = Order::with(['user'])->get();
        return OrderResource::collection($order);
    }

    public function store(StoreOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order = Order::create($data);
        // Nah ITT küldjük el az e-mailt, ha létrejött a rendelés!
        $this->orderService->sendOrderConfirmationEmail($order); // OrderService-ben lévő sendOrder(kinemírom) osztályát(függvényét) meghívjuk!
        
        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        $order->load('user');
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        return ($order->delete()) ? response()->noContent() : abort(500);
    }
}
