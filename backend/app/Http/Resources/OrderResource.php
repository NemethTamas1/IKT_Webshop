<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "orderstatus" => $this->orderstatus,
            "totalamount" => $this->totalamount,
            "totalquantity" => $this->totalquantity,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "orderer" => $this->whenLoaded('user', function () {
                return [
                    "username" => $this->user->username,
                    "email" => $this->user->email,
                    "shipping_country" => $this->user->shipping_country,
                    "shipping_city" => $this->user->shipping_city,
                    "shipping_zip" => $this->user->shipping_zip,
                    "shipping_street" => $this->user->shipping_street,
                    "shipping_street_number" => $this->user->shipping_street_number,
                ];
            }),
        ];
    }
}
