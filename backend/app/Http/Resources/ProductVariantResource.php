<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "product_id" => $this->product_id,
            "quantity" => $this->quantity,
            "unit" => $this->unit,
            "flavour" => $this->flavour,
            "price" => $this->price,
            "stock" => $this->stock,
            "available" => $this->available,
            "image_path"=> $this->image_path,
        ];
    }   
}
