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
            "stock" => $this->stock,
            "price" => $this->price,
            "available" => $this->available,
            "image_path" => $this->image_path,
            "created_at" =>$this->created_at,
            "updated_at" =>$this->updated_at,
            "deleted_at" => $this->deleted_at,
            "product" => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
