<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TransaksiBaruNotification;
use App\Notifications\RentalApprovedNotification;
use App\Notifications\BuktiPembayaranUploadedNotification;

class RentalController extends Controller
{
    // =============================
    // USER MENYEWA PRODUK
    // =============================
    public function store(Request $request, Product $product)
    {
        $days = $request->days ?? 1;

        if ($product->stok <= 0) {
            return back()->with('error', 'Stok produk habis!');
        }

        $total = $product->price_per_day * $days;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'days' => $days,
            'total_price' => $total,
            'payment_proof' => null,
            'status' => 'pending',
            'rental_date' => now(),
            'return_date' => null,
            'is_returned' => false,
        ]);

        $product->decrement('stok');

        // Notifikasi admin
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
        $rentals = Rental::where('user_id', auth()->id())
            ->with('product')
            ->orderBy('rental_date', 'desc')
            ->get();
        return view('user.rentals', compact('rentals'));
    }

    // =============================
    // ADMIN LIHAT SEMUA TRANSAKSI
    // =============================
    public function adminRentals()
    {
        $rentals = Rental::with(['user', 'product'])
            ->orderBy('rental_date', 'desc')
            ->get();
        return view('admin.rentals', compact('rentals'));
    }

    // =============================
    // ADMIN UPDATE STATUS
    // =============================
    public function update(Request $request, Rental $rental)
    {
        $oldStatus = $rental->status;
        $newStatus = $request->status;

        // Jika status diubah menjadi 'returned'
        if ($newStatus === 'returned' && $oldStatus === 'approved') {
            $rental->update([
                'status' => 'returned',
                'is_returned' => true,
                'return_date' => now(),
            ]);
            // Kembalikan stok produk
            $rental->product->increment('stok');

            return back()->with('success', 'Barang berhasil dikembalikan.');
        }

        // Update status lain (pending, approved)
        $rental->update(['status' => $newStatus]);

        // Notifikasi user jika disetujui
        if ($newStatus === 'approved' && $oldStatus !== 'approved') {
            $rental->user->notify(new RentalApprovedNotification($rental));
        }

        return back()->with('success', 'Status penyewaan berhasil diperbarui menjadi ' . ucfirst($newStatus) . '!');
    }

    // =============================
    // UPLOAD BUKTI PEMBAYARAN
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

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // =============================
    // RETURN BARANG (alternatif tombol return)
    // =============================
    public function returnItem($id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status !== 'approved') {
            return back()->with('error', 'Barang belum disetujui untuk dikembalikan.');
        }

        $rental->update([
            'status' => 'returned',
            'is_returned' => true,
            'return_date' => now(),
        ]);

        $rental->product->increment('stok');

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    // =============================
    // HAPUS TRANSAKSI
    // =============================
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status === 'pending') {
            $rental->product->increment('stok');
        }

        if ($rental->payment_proof && Storage::disk('public')->exists($rental->payment_proof)) {
            Storage::disk('public')->delete($rental->payment_proof);
        }

        $rental->delete();

        return back()->with('success', 'Transaksi penyewaan berhasil dihapus.');
    }
}
