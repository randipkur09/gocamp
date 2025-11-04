<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();

        // Data tambahan (kalau nanti ada transaksi & penyewa)
        $renters = 12; // sementara statis
        $transactionsToday = 5; // sementara statis
        $totalIncome = 1250000; // sementara statis

        return view('admin.dashboard', compact('products', 'renters', 'transactionsToday', 'totalIncome'));
    }
}
