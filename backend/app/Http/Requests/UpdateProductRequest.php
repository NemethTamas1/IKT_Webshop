<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:categories,id'],
            'brand_id'     => ['required', 'exists:brands,id'],
            'name'         => ['required', 'string', 'max:100'],
            'slug'         => ['required', 'string', 'max:100'],
            'description'  => ['required', 'string'],
            'product_line' => ['required', 'string'],
            'available'    => ['boolean'],
        ];
    }
}
