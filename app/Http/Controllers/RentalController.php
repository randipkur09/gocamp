<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    // Sewa produk
    public function store(Request $request, Product $product)
    {
        $days = $request->days ?? 1;
        $total = $product->price * $days;

        Rental::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'days' => $days,
            'total_price' => $total,
        ]);

        return back()->with('success', 'Berhasil menyewa produk!');
    }

    // Daftar sewa user
    public function userRentals()
    {
        $rentals = Rental::with('product')->where('user_id', Auth::id())->latest()->get();
        return view('user.rentals', compact('rentals'));
    }

    // Admin lihat semua transaksi
    public function adminRentals()
    {
        $rentals = Rental::with(['product', 'user'])->latest()->get();
        return view('admin.rentals', compact('rentals'));
    }

    public function update(Request $request, Rental $rental)
{
    $rental->update([
        'status' => $request->status,
    ]);

    return back()->with('success', 'Status penyewaan diperbarui!');
}
public function uploadProof(Request $request, Rental $rental)
{
    $request->validate([
        'payment_proof' => 'required|image|max:2048',
    ]);

    $path = $request->file('payment_proof')->store('payments', 'public');

    $rental->update([
        'payment_proof' => $path,
    ]);

    return back()->with('success', 'Bukti pembayaran berhasil diupload!');
}
public function uploadPayment(Request $request, $id)
{
    $rental = Rental::findOrFail($id);

    if ($rental->payment_proof) {
        return back()->with('error', 'Bukti pembayaran sudah diupload.');
    }

    $request->validate([
        'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $path = $request->file('payment_proof')->store('payments', 'public');
    $rental->payment_proof = $path;
    $rental->save();

    return back()->with('success', 'Bukti pembayaran berhasil diupload.');
}

public function returnItem($id)
{
    $rental = Rental::findOrFail($id);

    // Pastikan hanya bisa dikembalikan kalau statusnya 'approved'
    if ($rental->status !== 'approved') {
        return back()->with('error', 'Barang belum disetujui untuk dikembalikan.');
    }

    $rental->update([
        'is_returned' => true,
        'status' => 'returned',
        'return_date' => now(),
    ]);

    return back()->with('success', 'Barang berhasil dikembalikan.');
}



}
