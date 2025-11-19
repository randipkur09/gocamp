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

        // Ambil semua penyewaan lengkap dengan relasi user & product
        $rentals = Rental::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total penyewa unik
        $renters = User::whereHas('rentals')->count();

        // Hitung transaksi hari ini
        $transactionsToday = Rental::whereDate('created_at', Carbon::today())->count();

        // Hitung total pemasukan = jumlah * harga_per_hari * durasi
        $totalIncome = Rental::with('product')->get()->sum(function ($rental) {
            if (!$rental->product) return 0;
            return $rental->product->price * $rental->days;
        });

        // Return semua data ke dashboard admin
        return view('admin.dashboard', compact(
            'products',
            'rentals',
            'renters',
            'transactionsToday',
            'totalIncome'
        ));
    }
}