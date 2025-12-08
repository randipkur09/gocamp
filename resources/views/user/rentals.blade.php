@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-4xl font-bold text-slate-900 mb-2">Transaksi Penyewaan Saya</h1>
      <p class="text-slate-600">Kelola dan pantau semua rental Anda di sini.</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-green-700 text-sm font-semibold">{{ session('success') }}</p>
      </div>
    @elseif(session('error'))
      <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-red-700 text-sm font-semibold">{{ session('error') }}</p>
      </div>
    @endif

    <!-- Empty State -->
    @if($rentals->isEmpty())
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-slate-600 text-lg">Anda belum memiliki transaksi penyewaan.</p>
        <a href="{{ route('user.dashboard') }}" class="mt-4 inline-block px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
          Mulai Sewa Sekarang
        </a>
      </div>
    @else
      <!-- Rentals Table -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-slate-200">
              <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">No</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Nama Alat</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Durasi</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Total Harga</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Tanggal Sewa</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Status</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              @foreach($rentals as $index => $r)
                <tr class="hover:bg-slate-50 transition-colors">
                  <td class="px-6 py-4 text-slate-900">{{ $index + 1 }}</td>
                  <td class="px-6 py-4 text-slate-900 font-medium">{{ $r->product->name }}</td>
                  <td class="px-6 py-4 text-slate-700">{{ $r->days }} hari</td>
                  <td class="px-6 py-4 text-slate-900 font-semibold">Rp{{ number_format($r->total_price, 0, ',', '.') }}</td>
                  <td class="px-6 py-4 text-slate-700">{{ $r->created_at->format('d M Y') }}</td>
                  <td class="px-6 py-4">
                    <!-- Status Badge -->
                    @if($r->status == 'pending')
                      <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu</span>
                    @elseif($r->status == 'approved')
                      <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Disetujui</span>
                    @elseif($r->status == 'rejected')
                      <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Ditolak</span>
                    @else
                      <span class="inline-block px-3 py-1 bg-slate-100 text-slate-800 text-xs font-semibold rounded-full">{{ ucfirst($r->status) }}</span>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    <div class="space-y-2">
                      <!-- Pilihan Bank -->
                      @if($r->status == 'pending' && !$r->payment_proof)
                        <div class="flex gap-2">
                          <button onclick="alert('Nomor Rekening Mandiri: 123-456-7890')" class="p-2 bg-white text-gray-800 border border-slate-300 rounded hover:bg-slate-100" title="Mandiri">
    <img src="{{ asset('icons/mandiri.png') }}" alt="BCA" class="w-5 h-5">
</button>

<button onclick="alert('Nomor Rekening BRI: 987-654-3210')" class="p-2 bg-white text-gray-800 border border-slate-300 rounded hover:bg-slate-100" title="BRI">
    <img src="{{ asset('icons/bri.png') }}" alt="BRI" class="w-5 h-5">
</button>

<button onclick="alert('Nomor Rekening SeaBank: 111-222-3333')" class="p-2 bg-white text-gray-800 border border-slate-300 rounded hover:bg-slate-100" title="SeaBank">
    <img src="{{ asset('icons/seabank.jpeg') }}" alt="SeaBank" class="w-5 h-5">
</button>
                        </div>
                      @endif

                      <!-- Upload Payment Proof -->
                      @if(!$r->payment_proof && $r->status == 'pending')
                        <form action="{{ route('user.uploadPayment', $r->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-2 mt-2">
                          @csrf
                          <input 
                            type="file" 
                            name="payment_proof" 
                            accept="image/*"
                            required
                            class="flex-1 text-sm border border-slate-300 rounded px-2 py-1"
                          >
                          <button 
                            type="submit"
                            class="px-3 py-1 bg-cyan-500 text-white text-sm font-semibold rounded hover:bg-cyan-600 transition-colors"
                          >
                            Upload
                          </button>
                        </form>
                      @elseif($r->payment_proof)
                        <div class="text-center mt-2">
                          <a 
                            href="{{ asset('storage/' . $r->payment_proof) }}" 
                            target="_blank"
                            class="inline-block"
                          >
                            <img 
                              src="{{ asset('storage/' . $r->payment_proof) }}" 
                              alt="Bukti Pembayaran"
                              class="w-12 h-12 object-cover rounded border border-slate-300 hover:scale-110 transition-transform cursor-pointer"
                            >
                          </a>
                          <p class="text-xs text-green-600 font-semibold mt-1">Sudah Upload</p>
                        </div>
                      @endif

                      <!-- Delete Rental -->
                      @if($r->status == 'pending')
                        <form 
                          action="{{ route('user.rentals.destroy', $r->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                          class="mt-2"
                        >
                          @csrf
                          @method('DELETE')
                          <button 
                            type="submit"
                            class="w-full px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600 transition-colors"
                          >
                            Hapus
                          </button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
