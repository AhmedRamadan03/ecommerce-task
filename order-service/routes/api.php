<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;


Route::middleware('checkRole:customer')->group(function() {
    Route::get('orders', [OrderController::class,'index']);
    Route::post('orders', [OrderController::class,'store']);
});

Route::middleware('checkRole:admin,seller')->group(function() {
    Route::get('admin/orders', [OrderController::class,'allOrders']);
    Route::patch('orders/{id}/status', [OrderController::class,'updateStatus']);
});
