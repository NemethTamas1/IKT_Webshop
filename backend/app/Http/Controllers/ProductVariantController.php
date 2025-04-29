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
    public function show($id)
    {
        $productVariant = ProductVariant::with('product')->findOrFail($id);
        return new ProductVariantResource($productVariant);
    }
    public function update(UpdateProductVariantRequest $request, $id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $data = $request->validated();
        $productVariant->update($data);
        return new ProductVariantResource($productVariant);
    }
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();
        return response()->noContent();
    }
}
