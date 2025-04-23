<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands);
    }

    public function store(StoreBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        $brand = Brand::create($data);
        return new StoreBrandRequest($brand);
    }
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        $brand->update($data);
        return new BrandResource($brand);
    }
    public function destroy(Brand $brand)
    {
        return ($brand->delete()) ? response()->noContent() : abort(500);
    }
}
