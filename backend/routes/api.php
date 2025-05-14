<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);
Route::apiResource('/brands', BrandController::class);
Route::apiResource('/productvariants', ProductVariantController::class);
Route::apiResource('/orders', OrderController::class);

Route::apiResource('/users', UserController::class);
