<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rental;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $products = Product::all();

        // Ambil semua penyewaan beserta relasinya (user dan produk)
        $rentals = Rental::with(['product', 'user'])->latest()->get();

        // Data tambahan (bisa dikembangkan nanti)
        $renters = 12; // sementara statis
        $transactionsToday = 5; // sementara statis
        $totalIncome = 1250000; // sementara statis

        // Kirim semua data ke view dashboard
        return view('admin.dashboard', compact(
            'products',
            'rentals',
            'renters',
            'transactionsToday',
            'totalIncome'
        ));
    }
}