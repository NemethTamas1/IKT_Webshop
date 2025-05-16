<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "username" => ["required", "between:8,50", Rule::unique('users')->ignore($this->route('user'))],
            "name" => ['required', 'string', 'max:100'],
            "password" => ['nullable'],
            "email" => ["required", "email", "between:20,100", Rule::unique('users')->ignore($this->route('user'))],
            "phone" => ['nullable', 'string', 'max:20'],
            "country" => ['nullable', 'string', 'max:60'],
            "city" => ['nullable', 'string', 'max:40'],
            "zip" => ['nullable', 'string', 'max:10'],
            "street_name" => ['nullable', 'string', 'max:60'],
            "street_type" => ['nullable', 'string', 'max:60'],
            "street_number" => ['nullable', 'integer', 'min:1', 'max:200'],
        ];
    }
}
