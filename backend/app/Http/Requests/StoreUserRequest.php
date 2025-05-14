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
            "username" => ['required', 'unique:users', 'between:8,50'],
            "password" => ['required'],
            "email" => ['required', 'unique:users', 'between:20,100'],
            "shipping_country" => ['required', 'between:5,60', 'string'],
            "shipping_city" => ['required', 'between:3,40', 'string'],
            "shipping_zip" => ['required', 'string', 'max:10'],
            "shipping_street" => ['required', 'between:5,60', 'string'],
            "shipping_street_number" => ['required', 'integer', 'max:200'], // egyelőre 200-zal maxolva az út/tér/utca SZÁMA
        ];
    }
}
