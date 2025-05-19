<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'max:100'],
            "password" => ['required'],
            "email" => ['required', 'email', 'unique:users', 'between:15,100'],
            "phone" => ['nullable', 'string', 'max:20'],
            "country" => ['nullable', 'string', 'max:60'],
            "city" => ['nullable', 'string', 'max:40'],
            "zip" => ['nullable', 'string', 'max:10'],
            "street_name" => ['nullable', 'string', 'max:60'],
            "street_type" => ['nullable', 'string', 'max:60'],
            "street_number" => ['nullable', 'integer', 'min:1', 'max:200'],
            "floor" => ['nullable', 'string', 'max:20'],
        ];
    }
}
