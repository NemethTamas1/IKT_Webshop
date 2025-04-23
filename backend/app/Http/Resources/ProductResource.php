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
            'category_id' => $this->whenLoaded('categories', $this->id),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'product_line' => $this->product_line,
            'price' => $this->price,
            'avaliable' => $this->avaliable,
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'slug' => $category->brand,
                        'description' => $category->pivot->stock,
                    ];
                });
            })
        ];
    }
}
