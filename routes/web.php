<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', function () {
    return view('product');
});

// Admin dashboard (Materio)
Route::get('/admin', function () {
    return view('content.dashboard.dashboards-analytics');
})->name('dashboard-analytics');
