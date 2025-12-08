@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Kelola produk dan transaksi penyewaan Anda</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-blue-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Produk -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Produk</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $products->count() }}</h3>
            </div>
            <div class="bg-cyan-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Penyewa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Penyewa</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $renters }}</h3>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Transaksi Hari Ini -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Transaksi Hari Ini</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $transactionsToday }}</h3>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Products Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Produk</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Harga / Hari</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Gambar</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $p)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $p->category ? $p->category->name : '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($p->price_per_day, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $p->stok > 5 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $p->stok }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="h-10 w-10 rounded-lg object-cover">
                        @else
                            <span class="text-gray-400 text-xs">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm flex justify-center gap-2">
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 font-medium text-xs">Edit</a>
                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 font-medium text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">Belum ada produk tersedia</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Rentals Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Penyewaan</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Penyewa</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Durasi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pengembalian</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rentals as $r)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $r->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->days }} hari</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($r->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if($r->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($r->status == 'approved') bg-green-100 text-green-800
                            @elseif($r->status == 'returned') bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $r->return_date ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if ($r->status == 'approved' && !$r->is_returned)
                        <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-3 py-1.5 bg-cyan-100 text-cyan-700 rounded-lg hover:bg-cyan-200 transition duration-200 font-medium text-xs">
                                Dikembalikan
                            </button>
                        </form>
                        @else
                        <span class="text-gray-400 text-xs">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
