<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->whenLoaded('category', $this->id),
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'product_line' => $this->product_line,
            'available' => $this->available,
            'created_at' => $this->created_at,
            'category' => $this->whenLoaded('category', function () {
                return new CategoryResource($this->category);
            }),
            'brand' => $this->whenLoaded('brand', function() {
                return new BrandResource($this->brand);
            }),
            'productvariants' => ProductVariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}
