@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Kelola Transaksi Penyewaan</h1>
    <p class="text-gray-600 mt-1">Konfirmasi, kembalikan, atau hapus transaksi yang masuk</p>
</div>

<!-- Alerts -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3">
    <p class="font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
    <p class="font-medium">{{ session('error') }}</p>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">User</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Produk</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Durasi (hari)</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Total Harga</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Bukti Pembayaran</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Tanggal Sewa</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Tanggal Kembali</th>
                    <th class="px-6 py-4 text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rentals as $r)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->days }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($r->total_price,0,',','.') }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($r->payment_proof)
                            <a href="{{ asset('storage/'.$r->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat Bukti</a>
                        @else
                            <span class="text-gray-400 text-xs">Belum Upload</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if($r->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($r->status == 'approved') bg-green-100 text-green-800
                            @elseif($r->status == 'returned') bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->rental_date ? $r->rental_date->format('d-m-Y') : '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->return_date ? $r->return_date->format('d-m-Y') : '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 flex flex-col gap-1">
                        @if($r->status == 'pending')
                            <!-- Konfirmasi / Approve -->
                            <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-4 py-2 bg-green-100 text-green-700 rounded hover:bg-green-200">
                                    Konfirmasi
                                </button>
                            </form>

                            <!-- Hapus -->
                            <form action="{{ route('admin.rentals.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                    Hapus
                                </button>
                            </form>

                        @elseif($r->status == 'approved')
                            <!-- Tombol Return -->
                            <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="returned">
                                <button type="submit" class="px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                    Barang Dikembalikan
                                </button>
                            </form>

                        @elseif($r->status == 'returned')
                            <span class="text-green-600 font-medium text-xs">Selesai</span>
                            <!-- Hapus setelah returned -->
                            <form action="{{ route('admin.rentals.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
