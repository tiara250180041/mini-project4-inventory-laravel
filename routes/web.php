<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang dilindungi Login
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/products');
    });

    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
});