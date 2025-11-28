@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
  <div>
    <h1 class="text-4xl font-bold text-gray-900">Kelola Produk Camping</h1>
    <p class="text-gray-600 mt-1">Atur katalog peralatan camping Anda</p>
  </div>
  <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-blue-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Tambah Produk
  </a>
</div>

<!-- Success Alert -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start gap-3 animate-in fade-in duration-300">
  <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
  </svg>
  <div>
    <p class="font-medium">Sukses!</p>
    <p class="text-sm">{{ session('success') }}</p>
  </div>
</div>
@endif

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Harga / Hari</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Stok</th>
          <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Gambar</th>
          <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($products as $p)
        <tr class="hover:bg-gray-50 transition duration-200">
          <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
          <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($p->price_per_day, 0, ',', '.') }}</td>
          <td class="px-6 py-4 text-sm">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $p->stok > 5 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
              {{ $p->stok ?? '0' }}
            </span>
          </td>
          <td class="px-6 py-4 text-sm">
            @if($p->image)
              <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="h-12 w-12 rounded-lg object-cover border border-gray-200">
            @else
              <span class="text-gray-400 text-xs">Tidak ada</span>
            @endif
          </td>
          <td class="px-6 py-4 text-sm flex justify-center gap-2">
            <a href="{{ route('admin.products.edit', $p->id) }}" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 font-medium">
              Edit
            </a>
            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 font-medium">
                Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-6 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-sm font-medium">Belum ada produk</p>
            <p class="text-xs text-gray-400 mt-1">Mulai dengan menambahkan produk baru</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
