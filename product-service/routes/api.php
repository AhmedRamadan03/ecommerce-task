<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// أي request يمر من middleware اللي يتحقق من token و role
Route::middleware('checkRole:admin,seller')->group(function() {
    Route::apiResource('categories', CategoryController::class)->except(['index','show']);
   
    Route::apiResource('products', ProductController::class)->except(['index','show']);



});
    Route::get('products/{id}/stock', [ProductController::class,'stock']);

// أي حد يقدر يشوف الأقسام والمنتجات
Route::get('categories', [CategoryController::class,'index']);
Route::get('categories/{id}', [CategoryController::class,'show']);

Route::get('products', [ProductController::class,'index']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::patch('products/{id}/update-stock', [ProductController::class,'updateStock']);
