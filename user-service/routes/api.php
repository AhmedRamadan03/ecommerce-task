<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']); // public register -> we'll keep it creating 'customer' role by default
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'me']);

        // مثال: مسارات خاصة بالـ admin فقط
        Route::get('admin-only', fn() => ['msg' => 'Hello Admin'])->middleware('role:admin');

        // seller or admin
        Route::get('seller-or-admin', fn() => ['msg' => 'Hello Seller or Admin'])->middleware('role:admin|seller');
    });
});

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-only', function () {
    return response()->json(['message' => 'Welcome Admin!']);
});

Route::middleware(['auth:sanctum', 'role:seller'])->get('/seller-only', function () {
    return response()->json(['message' => 'Welcome Seller!']);
});

Route::middleware(['auth:sanctum', 'role:customer'])->get('/customer-only', function () {
    return response()->json(['message' => 'Welcome Customer!']);
});
