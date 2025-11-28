@extends('layouts.app')

@section('content')
<div x-data="{ showModal: false, selectedProduct: {}, rentalDays: 1 }" class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
  <!-- Header Section -->
  <div class="bg-white border-b border-slate-100 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="mb-2">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
          Selamat Datang di GoCamp!
        </h1>
      </div>
      <p class="text-slate-600 text-lg">Temukan peralatan camping terbaik untuk petualanganmu.</p>
    </div>
  </div>

  <!-- Alerts Section -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @if ($errors->any())
      <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <ul class="list-disc list-inside text-red-700 text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('success'))
      <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        {{ session('error') }}
      </div>
    @endif
  </div>

  <!-- Products Grid -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($products as $p)
        <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-100">
          <!-- Product Image with proper aspect ratio -->
          <div class="relative w-full bg-slate-100 overflow-hidden flex items-center justify-center" style="aspect-ratio: 16/12;">
            <img 
              src="{{ asset('storage/' . $p->image) }}"
              alt="{{ $p->name }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
          </div>
          
          <!-- Card Body -->
          <div class="p-6">
            <h3 class="text-xl font-semibold text-slate-800 mb-2 line-clamp-2">{{ $p->name }}</h3>
            <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $p->description ?? 'Tidak ada deskripsi' }}</p>
            
            <!-- Price Badge -->
            <div class="mb-4 inline-block bg-gradient-to-r from-cyan-50 to-blue-50 px-3 py-2 rounded-lg border border-cyan-200">
              <p class="text-lg font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                Rp {{ number_format($p->price_per_day, 0, ',', '.') }}<span class="text-sm">/hari</span>
              </p>
            </div>
            
            <!-- Detail Button -->
            <a 
              href="{{ route('products.show', $p->id) }}"
              class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg hover:from-cyan-600 hover:to-blue-700 transition-all duration-200 block text-center"
            >
              Lihat Detail
            </a>
          </div>
        </div>
      @empty
        <div class="text-center py-16">
          <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 00-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <p class="text-slate-500 text-lg">Belum ada produk yang tersedia saat ini.</p>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Product Detail Modal -->
  <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div x-show="showModal" @click="showModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
      
      <div x-show="showModal" x-transition class="inline-block align-bottom bg-white rounded-2xl shadow-xl transform transition-all w-full max-w-2xl">
        <div class="bg-white px-6 py-6 rounded-2xl">
          <!-- Modal Header -->
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-2xl font-bold text-slate-900" x-text="selectedProduct.name"></h3>
            <button @click="showModal = false" type="button" class="text-slate-400 hover:text-slate-600">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Modal Content -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Image Section -->
            <div class="bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center" style="aspect-ratio: 16/12;">
              <img :src="'/storage/' + selectedProduct.image" class="w-full h-full object-contain">
            </div>

            <!-- Info Section -->
            <div class="space-y-4">
              <div>
                <p class="text-slate-600 text-sm">Harga Sewa</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                  Rp <span x-text="selectedProduct.price_per_day ? selectedProduct.price_per_day.toLocaleString('id-ID') : '0'"></span>
                </p>
                <p class="text-slate-600 text-sm">per hari</p>
              </div>

              <div class="bg-slate-50 p-4 rounded-lg">
                <p class="text-slate-700" x-text="selectedProduct.description || 'Tidak ada deskripsi'"></p>
              </div>

              <!-- Rental Form -->
              <form :action="`/rent/${selectedProduct.id}`" method="POST" class="space-y-4">
                @csrf
                
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Durasi Sewa (hari)</label>
                  <input 
                    type="number"
                    x-model.number="rentalDays"
                    min="1"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                  >
                </div>

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                  <p class="text-slate-600 text-sm mb-1">Total Harga</p>
                  <p class="text-2xl font-bold text-slate-900">
                    Rp <span x-text="(selectedProduct.price_per_day * rentalDays).toLocaleString('id-ID')"></span>
                  </p>
                </div>

                <input type="hidden" name="product_id" :value="selectedProduct.id">
                <input type="hidden" name="days" x-model.number="rentalDays">

                <button 
                  type="submit"
                  class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200"
                >
                  Sewa Sekarang
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
