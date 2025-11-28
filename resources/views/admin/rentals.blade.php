@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="mb-8">
  <h1 class="text-4xl font-bold text-gray-900">Daftar Transaksi Penyewaan</h1>
  <p class="text-gray-600 mt-1">Kelola dan proses semua transaksi penyewaan</p>
</div>

<!-- Success Alert -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3 animate-in fade-in duration-300">
  <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
  </svg>
  <div>
    <p class="font-medium">Berhasil!</p>
    <p class="text-sm">{{ session('success') }}</p>
  </div>
</div>
@endif

<!-- Error Alert -->
@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3 animate-in fade-in duration-300">
  <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
  </svg>
  <div>
    <p class="font-medium">Terjadi kesalahan!</p>
    <p class="text-sm">{{ session('error') }}</p>
  </div>
</div>
@endif

<!-- Rentals Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">#</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama User</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Produk</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Durasi (hari)</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total Harga</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Bukti Pembayaran</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
          <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($rentals as $r)
        <tr class="hover:bg-gray-50 transition duration-200">
          <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $loop->iteration }}</td>
          <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $r->user->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-900">{{ $r->product->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-900">{{ $r->days }}</td>
          <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($r->total_price, 0, ',', '.') }}</td>
          
          <!-- Bukti Pembayaran -->
          <td class="px-6 py-4 text-sm">
            @if($r->payment_proof)
              <a href="{{ asset('storage/' . $r->payment_proof) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 text-xs font-medium gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Bukti
              </a>
            @else
              <span class="text-gray-400 text-xs">Belum Upload</span>
            @endif
          </td>

          <!-- Status -->
          <td class="px-6 py-4 text-sm">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
              @if($r->status == 'pending') bg-yellow-100 text-yellow-800
              @elseif($r->status == 'approved') bg-green-100 text-green-800
              @elseif($r->status == 'returned') bg-gray-100 text-gray-800
              @else bg-gray-100 text-gray-800
              @endif">
              {{ ucfirst($r->status) }}
            </span>
          </td>

          <!-- Aksi -->
          <td class="px-6 py-4 text-sm">
            <div class="flex gap-2 justify-center flex-wrap">
              {{-- Approve --}}
              @if($r->status == 'pending')
                <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="inline">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="approved">
                  <button type="submit" class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition duration-200 font-medium text-xs flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Approve
                  </button>
                </form>
              @endif

              {{-- Return --}}
              @if($r->status == 'approved')
                <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="inline">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="returned">
                  <button type="submit" class="px-3 py-2 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition duration-200 font-medium text-xs flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Return
                  </button>
                </form>
              @endif

              {{-- Delete --}}
              <form action="{{ route('admin.rentals.destroy', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 font-medium text-xs flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                  Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="px-6 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-sm font-medium">Belum ada transaksi</p>
            <p class="text-xs text-gray-400 mt-1">Tidak ada data penyewaan untuk ditampilkan</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
