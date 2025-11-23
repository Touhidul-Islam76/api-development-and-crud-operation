<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/apiCheck', function() {
    return response()->json(['status' => 'API is working fine']);
});

Route::get('/allProducts', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);