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
            'name' => ['required', 'string', 'unique:brands', 'max:50'],
            'slug' => ['string', 'max:50', 'unique:brands'],
            'logo_path' => ['string', 'max:255', 'unique:brands'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
