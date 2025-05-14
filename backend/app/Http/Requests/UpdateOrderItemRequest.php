<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "ordered_quantity" => ['required','integer','min:1'],
            "unit_price" =>['required','integer','min:1'],
            "total_amount" => ['required','integer','min:1'],
        ];
    }
}
