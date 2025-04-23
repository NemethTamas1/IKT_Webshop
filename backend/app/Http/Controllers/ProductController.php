<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories','brands'])->get();
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = Product::create($data);
        return new ProductResource($product);
    }
    public function show(Product $product)
    {
        $product->load('categories');
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        return ($product->delete()) ? response()->noContent() : abort(500);
    }
}
