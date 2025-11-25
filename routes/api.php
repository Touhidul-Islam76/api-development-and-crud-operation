<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/apiCheck', function () {
    return response()->json(['status' => 'API is working fine']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/allProducts', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/productsUpdate/{product}', [ProductController::class, 'update']);
    Route::delete('/productsDelete/{product}', [ProductController::class, 'destroy']);
});
