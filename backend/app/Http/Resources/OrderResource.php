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
            "shipping_email" => $this->shipping_email,
            "shipping_name" => $this->shipping_name,
            "shipping_phone" => $this->shipping_phone,
            "shipping_country" => $this->shipping_country,
            "shipping_city" => $this->shipping_city,
            "shipping_zip" => $this->shipping_zip,
            "shipping_street_name" => $this->shipping_street_name,
            "shipping_street_type" => $this->shipping_street_type,
            "shipping_street_number" => $this->shipping_street_number,
            "orderstatus" => $this->orderstatus,
            "totalamount" => $this->totalamount,
            "totalquantity" => $this->totalquantity,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "orderer" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
