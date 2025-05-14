<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "user_id" => ["required", "exists:users,id"],
            "orderstatus" => ["required", "max:50", "string"],
            "totalamount" => ["required", "integer", "min:0"],
            "totalquantity" => ['required', 'integer', 'min:1', 'max:50'],
        ];
    }
}
