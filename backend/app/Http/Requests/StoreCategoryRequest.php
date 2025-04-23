<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:categories,category_name', 'string', 'max:35'],
            'slug' => ['string', 'max:255', 'unique:brands', 'slug'],
            'description' => ['string', 'max:255'],
        ];
    }
}
