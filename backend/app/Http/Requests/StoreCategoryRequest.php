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
            'category_name'=>['required','unique:categories,category_name','string', 'max:35'],
            'brand' => ['required', 'string', 'max:50'],
        ];
    }
}
