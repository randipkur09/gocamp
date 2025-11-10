<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

// =============================
// Redirect Root ke Login
// =============================
Route::get('/', function () {
    return redirect()->route('login');
});

// =============================
// AUTH ROUTES
// =============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================
// RENTAL ROUTES (umum)
// =============================
Route::put('/admin/rentals/{rental}', [RentalController::class, 'update'])->name('admin.rentals.update');
Route::post('/user/rentals/{rental}/upload', [RentalController::class, 'uploadProof'])->name('user.rentals.upload');
Route::post('/user/rentals/{id}/upload', [RentalController::class, 'uploadPayment'])->name('user.uploadPayment');
Route::post('/rentals/{id}/return', [RentalController::class, 'returnItem'])->name('rentals.return');

// =============================
// DASHBOARD ROUTES
// =============================
Route::middleware(['auth'])->group(function () {

    // =============================
    // ADMIN ROUTES
    // =============================
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/products', ProductController::class)->names('admin.products');
        Route::get('/admin/rentals', [RentalController::class, 'adminRentals'])->name('admin.rentals');
        Route::delete('/admin/rentals/{id}', [RentalController::class, 'destroy'])
            ->name('admin.rentals.destroy');
    });

    // =============================
    // USER ROUTES
    // =============================
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/rentals', [RentalController::class, 'userRentals'])->name('user.rentals');
    Route::delete('/user/rentals/{id}', [RentalController::class, 'destroy'])
        ->name('user.rentals.destroy');

    Route::post('/rent/{product}', [RentalController::class, 'store'])->name('rent.store');

    // Notifications
    Route::get('/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAllRead');

    // Profile
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/user/profile/destroy', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
});

// =============================
// CLEAR SESSION
// =============================
Route::post('/session/clear-account-deleted', function () {
    session()->forget('account_deleted');
    return response()->noContent();
})->name('session.clear.account_deleted');
