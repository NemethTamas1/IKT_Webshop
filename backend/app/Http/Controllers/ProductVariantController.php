<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Http\Resources\ProductVariantResource;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function index()
    {
        $productVariant = ProductVariant::with(['product'])->get();
        return ProductVariantResource::collection($productVariant);
    }
    public function store(StoreProductVariantRequest $request, ProductVariant $productVariant)
    {
        $data = $request->validated();
        $productVariant = ProductVariant::create($data);
        return new ProductVariantResource($productVariant);
    }
    public function show(ProductVariant $productVariant)
    {
        $productVariant->load('products');
        return new ProductVariantResource($productVariant);
    }
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $data = $request->validated();
        $productVariant->update($data);
        return new ProductVariantResource($productVariant);
    }
    public function destroy(ProductVariant $productVariant)
    {
        return ($productVariant->delete()) ? response()->noContent() : abort(500);
    }
}
