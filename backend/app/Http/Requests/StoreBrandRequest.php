<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['string', 'max:255', 'unique:brands', 'slug'],
            'logo_path' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ];
    }
}
