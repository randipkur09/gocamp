<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua produk yang diupload admin
        $products = Product::latest()->get();

        return view('user.dashboard', compact('products'));
    }
}
