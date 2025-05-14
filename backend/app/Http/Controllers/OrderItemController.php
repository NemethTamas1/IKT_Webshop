<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(["order"])->get();
        return OrderItemResource::collection($orderItems);
    }

    public function store(StoreOrderItemRequest $request)
    {
        $data = $request->validated();
        $orderItem = OrderItem::create($data);
        return new OrderItemResource($orderItem);
    }

    public function show($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['error' => 'Nem található rendelési tétel'], 404);
        }
        $orderItem->load(["order"]);
        return new OrderItemResource($orderItem);
    }

    public function update(UpdateOrderItemRequest $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $data = $request->validated();
        $orderItem->update($data);
        return new OrderItemResource($orderItem);
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        return ($orderItem->delete()) ? response()->noContent() : abort(500);
    }
}
