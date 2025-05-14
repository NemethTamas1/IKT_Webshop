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
            "username" => [
                "required",
                "exists:users",
                "between:8,50",
                Rule::unique('users')->ignore($this->route('user'))
            ],
            "password" => ['required'],
            "email" => [
                "required",
                "email", // Hiányzott a formátum ellenőrzés
                "between:20,100",
                Rule::unique('users')->ignore($this->route('user'))
            ],
            "shipping_country" => ['required', 'between:5,60', 'string'],
            "shipping_city" => ['required', 'between:3,40', 'string'],
            "shipping_zip" => ['required', 'string', 'max:10'],
            "shipping_street" => ['required', 'between:5,60', 'string'],
            "shipping_street_number" => ['required', 'integer', 'max:200'],
        ];
    }
}
