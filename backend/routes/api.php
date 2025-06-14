<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->id;
})->middleware('auth:sanctum');

Route::apiResource('/products', ProductController::class);

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/brands', BrandController::class);
Route::apiResource('/productvariants', ProductVariantController::class);
Route::apiResource('/orders', OrderController::class);
Route::apiResource('/orderitems', OrderItemController::class);

Route::apiResource("/authenticate", AuthController::class);
Route::post("/authenticate", [AuthController::class, "authorization"])->name("auth.authenticate");

Route::apiResource('/users', UserController::class);
