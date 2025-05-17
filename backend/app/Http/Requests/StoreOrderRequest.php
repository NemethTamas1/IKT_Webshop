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
            "shipping_email" => ['required', 'email', 'max:100'],
            "shipping_name" => ['required', 'string', 'max:100'],
            "shipping_phone" => ['required', 'string', 'max:20'],
            "shipping_country" => ['required', 'string', 'max:60'],
            "shipping_city" => ['required', 'string', 'max:40'],
            "shipping_zip" => ['required', 'string', 'max:10'],
            "shipping_street_name" => ['required', 'string', 'max:60'],
            "shipping_street_type" => ['required', 'string', 'max:60'],
            "shipping_street_number" => ['required', 'integer', 'max:9999'],
            "floor" => ['nullable', 'string', 'max:20'],
            "orderstatus" => ['string', 'max:50'],
            "totalamount" => ['required', 'integer', 'min:0'],
            "totalquantity" => ['required', 'integer', 'min:1', 'max:50'],
        ];
    }
}
