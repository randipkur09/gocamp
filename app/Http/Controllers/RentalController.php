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

        // Cek stok produk
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
            'payment_proof' => null,
            'status' => 'pending',
            'return_date' => null,
            'is_returned' => false,
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
        $rentals = Rental::where('user_id', auth()->id())->with('product')->get();
        return view('user.rentals', compact('rentals'));
    }

    // =============================
    // ADMIN LIHAT SEMUA TRANSAKSI
    // =============================
    public function adminRentals()
    {
        $rentals = Rental::with(['user', 'product'])->get();
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

        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $rental->user->notify(new RentalApprovedNotification($rental));
        }

        return back()->with('success', 'Status penyewaan berhasil diperbarui menjadi ' . ucfirst($request->status) . '!');
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

        // Notifikasi admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::send($admin, new BuktiPembayaranUploadedNotification($rental));
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // =============================
    // RETURN BARANG
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

        // Kembalikan stok
        $rental->product->increment('stock');

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    // =============================
    // HAPUS TRANSAKSI
    // =============================
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status === 'pending') {
            $rental->product->increment('stock');
        }

        if ($rental->payment_proof && Storage::disk('public')->exists($rental->payment_proof)) {
            Storage::disk('public')->delete($rental->payment_proof);
        }

        $rental->delete();

        return back()->with('success', 'Transaksi penyewaan berhasil dihapus.');
    }
}