<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::authorize('create', Product::class)->allowed();
    }
    public function rules(): array
    {
        return [
            'category_id'  => ['required', 'exists:categories,id'],
            'brand_id'     => ['required', 'exists:brands,id'],
            'name'         => ['required', 'string', 'max:100'],
            'slug'         => ['required', 'string', 'max:100', 'unique:products'],
            'description'  => ['required', 'string'],
            'product_line' => ['required', 'string'],
            'available'    => ['boolean'],
        ];
    }
}
