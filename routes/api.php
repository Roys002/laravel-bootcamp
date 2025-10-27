<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // RESTful routes
    Route::apiResource('products', ProductController::class);
    // Custom routes
    Route::post('products/{id}/restore', [ProductController::class, 'restore']);
});