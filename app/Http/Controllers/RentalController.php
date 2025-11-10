<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Product;
use App\Models\User;
use App\Notifications\TransaksiBaruNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class RentalController extends Controller
{
    // =============================
    // USER MENYEWA PRODUK
    // =============================
    public function store(Request $request, Product $product)
    {
        $days = $request->days ?? 1;

        // Cek stok dulu
        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis!');
        }

        $total = $product->price * $days;

        // Buat transaksi rental baru
        $rental = Rental::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'days' => $days,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Kurangi stok produk
        $product->decrement('stock');

        // Kirim notifikasi ke admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new TransaksiBaruNotification($rental));
        }

        return back()->with('success', 'Berhasil menyewa produk! Silakan upload bukti pembayaran.');
    }

    // =============================
    // DAFTAR SEWA USER
    // =============================
    public function userRentals()
    {
        $rentals = Rental::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.rentals', compact('rentals'));
    }

    // =============================
    // ADMIN LIHAT SEMUA TRANSAKSI
    // =============================
    public function adminRentals()
    {
        $rentals = Rental::with(['product', 'user'])->latest()->get();
        return view('admin.rentals', compact('rentals'));
    }

    // =============================
    // ADMIN UPDATE STATUS
    // =============================
    public function update(Request $request, Rental $rental)
    {
        $oldStatus = $rental->status;
        $rental->update([
            'status' => $request->status,
        ]);

        // Jika disetujui, kirim notifikasi ke user
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $rental->user->notify(new \App\Notifications\RentalApprovedNotification($rental));
        }

        return back()->with('success', 'Status penyewaan berhasil diperbarui menjadi ' . ucfirst($request->status) . '!');
    }

    // =============================
    // UPLOAD BUKTI PEMBAYARAN (USER)
    // =============================
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

        $rental->update([
            'payment_proof' => $path,
        ]);

        // Kirim notifikasi ke admin bahwa user sudah upload bukti
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::send($admin, new \App\Notifications\BuktiPembayaranUploadedNotification($rental));
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // =============================
    // RETURN BARANG (ADMIN ATAU USER)
    // =============================
    public function returnItem($id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status !== 'approved') {
            return back()->with('error', 'Barang belum disetujui untuk dikembalikan.');
        }

        $rental->update([
            'is_returned' => true,
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Tambahkan stok kembali ke produk
        $rental->product->increment('stock');

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    // =============================
    // HAPUS TRANSAKSI (ADMIN ATAU USER)
    // =============================
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);

        // Jika transaksi masih pending, stok dikembalikan
        if ($rental->status === 'pending') {
            $rental->product->increment('stock');
        }

        // Hapus file bukti pembayaran jika ada
        if ($rental->payment_proof && Storage::disk('public')->exists($rental->payment_proof)) {
            Storage::disk('public')->delete($rental->payment_proof);
        }

        $rental->delete();

        return back()->with('success', 'Transaksi penyewaan berhasil dihapus.');
    }
}
