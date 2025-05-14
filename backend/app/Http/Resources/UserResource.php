<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "password" => $this->password,
            "email" => $this->email,
            "shipping_country" => $this->shipping_country,
            "shipping_city" => $this->shipping_city,
            "shipping_zip" => $this->shipping_zip,
            "shipping_street" => $this->shipping_street,
            "shipping_street_number" => $this->shipping_street_number,
            "email_verified_at" => $this->email_verified_at,
            "created_at" => date_format($this->created_at, 'y.M.d H:m'),
            "updated_at" => date_format($this->updated_at, 'y.M.d H:m'),
            "deleted_at" => $this->deleted_at,
        ];
    }
}
