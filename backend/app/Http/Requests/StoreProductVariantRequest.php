<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'unique:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:10'],
            'flavour' => ['nullable', 'string', 'max:45'],
            'stock' => ['integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'available' => ['boolean'],
            'image_path' => ['nullable', 'string'],
        ];
    }
}
