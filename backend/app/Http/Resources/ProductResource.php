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
            'category_id' => $this->whenLoaded('categories',$this->id),
            'description' => $this->description,
            'weight' => $this->weight,
            'flavour' => $this->flavour,
            'price' => $this->price,
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        // 'category_id' => $category->id,
                        'category_name' => $category->category_name,
                        'brand' => $category->brand,
                        'stock' => $category->pivot->stock,
                        'available' => $category->pivot->available
                    ];
                });
            })
        ];
    }
}
