<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental; // pastikan import model Rental
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua produk yang diupload admin
        $products = Product::latest()->get();

        // Ambil semua transaksi user (aktif & histori)
        $rentals = Rental::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->get();

        // Ambil transaksi yang sudah berhasil (approved / returned)
        $completedRentals = Rental::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['approved', 'returned'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('products', 'rentals', 'completedRentals'));
    }
}
