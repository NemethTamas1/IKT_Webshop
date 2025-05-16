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
            "role" => $this->role,
            "username" => $this->username,
            "name" => $this->name,
            "password" => $this->password,
            "email" => $this->email,
            "phone" => $this->phone,
            "country" => $this->country,
            "city" => $this->city,
            "zip" => $this->zip,
            "street_name" => $this->street_name,
            "street_type" => $this->street_type,
            "street_number" => $this->street_number,
            "email_verified_at" => $this->email_verified_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
