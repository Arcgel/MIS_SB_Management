<?php

use App\Http\Controllers\Products\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductsController::class , 'Products']);

Route::get('/storage/{imageName}', function ($imageName) {
    return response()->file(public_path('/images/' . $imageName));
});


