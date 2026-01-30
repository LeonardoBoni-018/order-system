<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::post("/login", [AuthController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/orders", [OrderController::class, "store"]);
});

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("products", ProductController::class);
});
