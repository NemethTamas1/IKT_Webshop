<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
            'slug' => ['required', 'string', 'max:255', 'unique:brands',],
            'logo_path' => ['string', 'max:255','unique:brands'],
            'description' => ['string', 'max:255'],
        ];
    }
}
