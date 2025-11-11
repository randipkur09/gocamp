<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

// =============================
// ROOT (redirect ke login)
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
// ROUTE YANG BUTUH LOGIN
// =============================
Route::middleware(['auth'])->group(function () {

    // =============================
    // ADMIN ROUTES
    // =============================
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Produk
        Route::resource('/admin/products', ProductController::class)->names('admin.products');

        // Penyewaan
        Route::get('/admin/rentals', [RentalController::class, 'adminRentals'])->name('admin.rentals');
        Route::put('/admin/rentals/{rental}', [RentalController::class, 'update'])->name('admin.rentals.update');
        Route::delete('/admin/rentals/{id}', [RentalController::class, 'destroy'])->name('admin.rentals.destroy');
    });

    // =============================
    // USER ROUTES
    // =============================
    Route::middleware('user')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        // Penyewaan produk
        Route::post('/rent/{product}', [RentalController::class, 'store'])->name('rent.store');
        Route::get('/user/rentals', [RentalController::class, 'userRentals'])->name('user.rentals');
        Route::post('/user/rentals/{id}/upload', [RentalController::class, 'uploadPayment'])->name('user.uploadPayment');
        Route::post('/rentals/{id}/return', [RentalController::class, 'returnItem'])->name('rentals.return');
        Route::delete('/user/rentals/{id}', [RentalController::class, 'destroy'])->name('user.rentals.destroy');

        // Profile user
        Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile.show');
        Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
        Route::delete('/user/profile/destroy', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
    });

    // =============================
    // Notifications
    // =============================
    Route::get('/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAllRead');
});

// =============================
// CLEAR SESSION (hapus pesan akun dihapus)
// =============================
Route::post('/session/clear-account-deleted', function () {
    session()->forget('account_deleted');
    return response()->noContent();
})->name('session.clear.account_deleted');
