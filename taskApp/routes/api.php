<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {

    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('category/store', [CategoryController::class, 'store']);
    Route::put('category/update/{id}',[CategoryController::class, 'update']);
    Route::delete('category/delete/{id}',[CategoryController::class, 'destroy']);

    Route::post('product/store', [ProductController::class, 'store']);
    Route::put('product/update/{id}',[ProductController::class, 'update']);
    Route::delete('product/delete/{id}',[ProductController::class, 'destroy']);
});

    
    Route::get('categories',[CategoryController::class, 'index']);
    Route::get('category/{id}',[CategoryController::class, 'show']);

    Route::get('products/{id}',[ProductController::class, 'index']);
    Route::get('product/{id}',[ProductController::class, 'show']);
    Route::post('products/product/search',[ProductController::class, 'search']);
