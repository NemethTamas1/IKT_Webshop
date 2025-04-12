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
            'category_id' => ['required'],
            'description' => ['required'],
            'weight' => ['required'],
            'flavour' => ['required'],
            'price' => ['required'],
        ];
    }
}
