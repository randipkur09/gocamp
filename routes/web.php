<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;

// =============================
// OTP & Lupa Password
// =============================
Route::get('/forgot-password', [OtpController::class, 'forgotPasswordView'])->name('forgot.view');
Route::post('/forgot-password', [OtpController::class, 'sendOtp'])->name('forgot.send');

Route::get('/verify-otp', [OtpController::class, 'verifyOtpView'])->name('otp.view');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/reset-password', [OtpController::class, 'resetPasswordView'])->name('reset.view');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('reset.submit');

// =============================
// ROOT → redirect ke login
// =============================
Route::get('/', function () {
    return redirect()->route('login');
});

// =============================
// AUTH
// =============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// tambahan OTP API
Route::post('/otp/send', [OtpController::class, 'sendOtp']);
Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
Route::post('/otp/reset', [OtpController::class, 'resetPassword']);

// =============================
// ROUTE YANG BUTUH LOGIN
// =============================
Route::middleware(['auth'])->group(function () {

    // =============================
    // ADMIN ROUTES
    // =============================
    Route::middleware('admin')->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // CRUD Produk
        Route::resource('/admin/products', ProductController::class)
            ->names('admin.products');

        // Semua transaksi rental
        Route::get('/admin/rentals', [RentalController::class, 'adminRentals'])->name('admin.rentals');

        // Update status rental
        Route::put('/admin/rentals/{rental}', [RentalController::class, 'update'])->name('admin.rentals.update');

        // Hapus transaksi rental
        Route::delete('/admin/rentals/{id}', [RentalController::class, 'destroy'])->name('admin.rentals.destroy');
        
        Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/rentals', [RentalController::class, 'adminRentals'])->name('admin.rentals');
});

    });

    // =============================
    // USER ROUTES
    // =============================
    Route::middleware('user')->group(function () {

        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

        // =============================
        // PROSES SEWA PRODUK
        // =============================

        // Membuat sewa baru
        Route::post('/rent/{product}', [RentalController::class, 'store'])->name('rent.store');

        // Halaman daftar sewa user
        Route::get('/user/rentals', [RentalController::class, 'userRentals'])->name('user.rentals');

        // Upload bukti pembayaran
        Route::post('/user/rentals/{id}/upload', [RentalController::class, 'uploadPayment'])->name('user.uploadPayment');

        // Mengembalikan barang
        Route::post('/user/rentals/{id}/return', [RentalController::class, 'returnItem'])->name('rentals.return');

        // User menghapus transaksi
        Route::delete('/user/rentals/{id}', [RentalController::class, 'destroy'])->name('user.rentals.destroy');

        // =============================
        // PROFILE USER
        // =============================
        Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile.show');
        Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
        Route::delete('/user/profile/destroy', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
    });

    // =============================
    // Notifikasi
    // =============================
    Route::get('/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAllRead');

    Route::get('/admin/notifications', [AdminController::class, 'notifications'])
        ->name('admin.notifications');
});

// =============================
// CLEAR SESSION
// =============================
Route::post('/session/clear-account-deleted', function () {
    session()->forget('account_deleted');
    return response()->noContent();
})->name('session.clear.account_deleted');
