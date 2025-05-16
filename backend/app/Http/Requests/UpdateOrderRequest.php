<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "shipping_email" => ['email', 'max:100'],
            "shipping_name" => ['string', 'max:100'],
            "shipping_phone" => ['string', 'max:20'],
            "shipping_country" => ['string', 'max:60'],
            "shipping_city" => ['string', 'max:40'],
            "shipping_zip" => ['string', 'max:10'],
            "shipping_street_name" => ['string', 'max:60'],
            "shipping_street_type" => ['string', 'max:60'],
            "shipping_street_number" => ['integer', 'max:9999'],

            "user_id" => ['exists:users,id'],
            "orderstatus" => ['string', 'max:50'],
            "totalamount" => ['integer', 'min:0'],
            "totalquantity" => ['integer', 'min:1', 'max:50'],
        ];
    }
}
