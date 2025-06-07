<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {        
        $products = Product::with(['category', 'brand','variants'])->get();
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
        $product->load(['category', 'brand','variants']);
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
