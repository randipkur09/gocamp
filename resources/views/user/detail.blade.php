@extends('layouts.app')

@section('content')
<div x-data="rentalData()" class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Product Detail Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">

        <!-- Product Image -->
        <div class="flex items-center justify-center bg-slate-100 rounded-xl p-4" style="aspect-ratio: 16/12;">
          <img 
            src="{{ asset('storage/' . $product->image) }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover rounded-lg"
          >
        </div>

        <!-- Product Info -->
        <div class="flex flex-col justify-between">
          <div>
            <h1 class="text-4xl font-bold text-slate-900 mb-4">{{ $product->name }}</h1>

            <!-- Price Section -->
            <div class="mb-6 bg-gradient-to-r from-cyan-50 to-blue-50 p-6 rounded-xl border border-cyan-200">
              <p class="text-slate-600 text-sm mb-1">Harga Sewa</p>
              <p class="text-4xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
                Rp {{ number_format($product->price_per_day, 0, ',', '.') }}
              </p>
              <p class="text-slate-600 text-sm mt-1">per hari</p>
            </div>

            <!-- Description -->
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-slate-900 mb-2">Deskripsi</h3>
              <p class="text-slate-700 leading-relaxed">
                {{ $product->description ?? 'Tidak ada deskripsi tersedia.' }}
              </p>
            </div>

            <!-- Stock & Rental Date Info -->
            <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
              <p class="text-slate-700 mb-2">
                <span class="font-semibold">Stok Tersedia:</span>
                <span class="text-cyan-600 font-bold">{{ $product->stok }} unit</span>
              </p>
              <p class="text-slate-700 mb-2">
                <span class="font-semibold">Tanggal Sewa:</span>
                <input type="date" 
                       x-model="rentalDate" 
                       :min="minDate" 
                       class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
              </p>
              <p class="text-slate-700">
                <span class="font-semibold">Tanggal Kembali:</span>
                <span class="text-slate-900 font-medium" x-text="returnDate"></span>
              </p>
            </div>
          </div>

          <!-- Rental Form -->
          <form action="{{ route('rent.store', $product->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
              <label for="days" class="block text-sm font-semibold text-slate-700 mb-2">
                Lama Sewa (hari)
              </label>
              <input 
                type="number"
                id="days"
                name="days"
                x-model.number="days"
                min="1"
                value="1"
                required
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
              >
            </div>

            <!-- Hidden input to submit selected rental date -->
            <input type="hidden" name="rental_date" :value="rentalDate">

            <button 
              type="submit"
              class="w-full py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg hover:from-cyan-600 hover:to-blue-700 transition-all duration-200"
            >
              Sewa Sekarang
            </button>

            <a 
              href="{{ route('user.dashboard') }}"
              class="block text-center py-3 border-2 border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition-colors"
            >
              Kembali
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Notification Modal -->
  @if(session('success'))
  <div x-data="{ showSuccessModal: true }" x-show="showSuccessModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden z-10">
      <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6">
        <div class="flex items-center gap-3">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <h3 class="text-xl font-bold">Berhasil!</h3>
        </div>
      </div>

      <div class="p-6">
        <p class="text-slate-700 mb-4">
          Penyewaan produk Anda berhasil diajukan. Status penyewaan akan segera diproses oleh admin.
        </p>
        <p class="text-slate-600 text-sm mb-6">
          Silakan cek halaman <strong>"Sewa Saya"</strong> untuk melihat status penyewaan dan detail pembayaran.
        </p>
      </div>

      <div class="flex gap-3 p-6 border-t border-slate-200 bg-slate-50">
        <button 
          @click="showSuccessModal = false"
          class="flex-1 px-4 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-100 transition-colors"
        >
          Tutup
        </button>
        <a
          href="{{ route('user.rentals') }}"
          class="flex-1 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-lg hover:shadow-lg transition-all text-center"
        >
          Cek Sewa Saya
        </a>
      </div>
    </div>
  </div>
  @endif
</div>

<script>
function rentalData() {
    return {
        rentalDate: new Date().toISOString().split('T')[0],
        days: 1,
        get returnDate() {
            if (!this.rentalDate || !this.days) return '-';
            const start = new Date(this.rentalDate);
            start.setDate(start.getDate() + parseInt(this.days));
            return start.toISOString().split('T')[0];
        },
        minDate: new Date().toISOString().split('T')[0],
    }
}
</script>
@endsection
