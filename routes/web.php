<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;

// =============================
// 🔐 AUTH ROUTES
// =============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::put('/admin/rentals/{rental}', [RentalController::class, 'update'])->name('admin.rentals.update');
Route::post('/user/rentals/{rental}/upload', [RentalController::class, 'uploadProof'])->name('user.rentals.upload');
Route::post('/user/rentals/{id}/upload', [App\Http\Controllers\RentalController::class, 'uploadPayment'])
    ->name('user.uploadPayment');



// =============================
// 🏠 DASHBOARD ROUTES
// =============================
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('admin');

    // User dashboard
    Route::get('/user/dashboard', [UserController::class, 'index'])
        ->name('user.dashboard');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/products', ProductController::class)->names('admin.products');
    });


Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
    });
});
Route::middleware(['auth'])->group(function() {
    Route::get('/user/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth')->group(function() {
    Route::post('/rent/{product}', [RentalController::class, 'store'])->name('rent.store');
    Route::get('/user/rentals', [RentalController::class, 'userRentals'])->name('user.rentals');

    Route::middleware('admin')->group(function() {
        Route::get('/admin/rentals', [RentalController::class, 'adminRentals'])->name('admin.rentals');
    });
});



});

