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
            "orderer" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
