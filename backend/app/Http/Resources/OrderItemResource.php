<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "product_variant_id" => $this->product_variant_id,
            "ordered_quantity" => $this->ordered_quantity,
            "unit_price" => $this->unit_price,
            "total_amount" => $this->total_amount,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "order" => $this->whenLoaded('order', function () {
                return new OrderResource($this->order);
            })
        ];
    }
}
