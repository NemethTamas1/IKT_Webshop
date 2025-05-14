<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ["required", "exists:orders,id"],
            'product_variant_id' => ["required", "exists:product_variants,id"],
            'ordered_quantity' => ["required", "integer", "min:1"],
            'unit_price' => ["required", "integer", "min:1"],
            'total_amount' => ["required", "integer", "min:1"],
        ];
    }
}
