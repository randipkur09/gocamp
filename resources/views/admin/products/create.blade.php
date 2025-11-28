@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="mb-8">
  <h1 class="text-4xl font-bold text-gray-900">Tambah Produk Baru</h1>
  <p class="text-gray-600 mt-1">Isi formulir di bawah untuk menambahkan produk camping baru</p>
</div>

<!-- Error Messages -->
@if ($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
  <div class="flex items-start gap-3">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    <div>
      <p class="font-medium">Terjadi kesalahan:</p>
      <ul class="mt-2 space-y-1">
        @foreach ($errors->all() as $error)
          <li class="text-sm">• {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif

<!-- Form -->
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Nama Produk -->
    <div class="md:col-span-2">
      <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Produk</label>
      <input type="text" name="name" placeholder="Contoh: Tenda Camping 2 Orang" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
      @error('name')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Harga -->
    <div>
      <label class="block text-sm font-semibold text-gray-900 mb-2">Harga (Rp / Hari)</label>
      <input type="number" name="price_per_day" placeholder="Contoh: 35000" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 @error('price_per_day') border-red-500 @enderror" value="{{ old('price_per_day') }}" required>
      @error('price_per_day')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Stok -->
    <div>
      <label class="block text-sm font-semibold text-gray-900 mb-2">Stok</label>
      <input type="number" name="stok" placeholder="Jumlah stok tersedia" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 @error('stok') border-red-500 @enderror" value="{{ old('stok') }}" required>
      @error('stok')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <!-- Deskripsi -->
  <div class="mb-6">
    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
    <textarea name="description" placeholder="Tuliskan deskripsi lengkap produk..." rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
    @error('description')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Gambar -->
  <div class="mb-8">
    <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar Produk</label>
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-cyan-500 hover:bg-cyan-50 transition duration-200" onclick="document.getElementById('image-input').click()">
      <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
      <p class="text-gray-600 font-medium">Klik untuk upload gambar</p>
      <p class="text-gray-400 text-sm">atau drag dan drop di sini</p>
    </div>
    <input type="file" id="image-input" name="image" class="hidden" accept="image/*">
    @error('image')
      <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Buttons -->
  <div class="flex gap-4 justify-between">
    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-50 transition duration-200 flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Kembali
    </a>
    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-blue-600 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
      </svg>
      Simpan Produk
    </button>
  </div>
</form>

@endsection
