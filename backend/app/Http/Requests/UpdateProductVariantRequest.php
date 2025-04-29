<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
       
        return [
            'product_id' => ['exists:products,id'],
            'quantity' => ['integer', 'min:1'],
            'unit' => ['string', 'max:10'],
            'flavour' => ['nullable', 'string', 'max:45'],
            'stock' => ['integer', 'min:0'],
            'price' => ['integer', 'min:0'],
            'available' => ['boolean'],
            'image_path' => ['nullable', 'string'],
        ];
    
    }
}
