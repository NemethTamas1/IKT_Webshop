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
            'category_id' => ['required','exists:categories,id'],
            'description' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'max:9999'],
            'flavour' => ['required', 'string', 'max:45'],
            'price' => ['required', 'integer'],
        ];
    }
}
