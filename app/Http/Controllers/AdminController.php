<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $products = Product::orderBy('created_at', 'desc')->get();

        // Ambil semua penyewaan
        $rentals = Rental::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total penyewa
        $renters = User::whereHas('rentals')->count();

        // Transaksi hari ini
        $transactionsToday = Rental::whereDate('created_at', Carbon::today())->count();

        // Total income
        $totalIncome = Rental::with('product')->get()->sum(function ($rental) {
            if (!$rental->product) return 0;
            return $rental->product->price_per_day * $rental->days;
        });

        return view('admin.dashboard', compact(
            'products',
            'rentals',
            'renters',
            'transactionsToday',
            'totalIncome'
        ));
    }

    // Halaman Semua Notifikasi Admin
    public function notifications()
    {
        // Ambil semua notifikasi milik admin
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->get();

        // Tandai semua sebagai sudah dibaca
        auth()->user()->unreadNotifications->markAsRead();

        return view('admin.notifikasi.index', compact('notifications'));
    }
}