<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:categories,name', 'string', 'max:35'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['string', 'max:255'],
        ];
    }
}
