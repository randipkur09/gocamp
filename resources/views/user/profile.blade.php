@extends('layouts.app')

@section('content')
<div x-data="{ deleteAccountModal: false }" class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">

      <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-8">
        <h2 class="text-3xl font-bold text-white">Profil Saya</h2>
      </div>

      <div class="p-8">

        <div class="text-center mb-8">
          <img 
            src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&w=400&h=400&fit=crop' }}" 
            class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-cyan-200 shadow-lg mb-4"
          >
          <h3 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h3>
        </div>

        <div class="space-y-4 mb-8">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600">Nama Lengkap</p>
              <p class="text-lg text-slate-900">{{ $user->name }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600">Email</p>
              <p class="text-lg text-slate-900 break-all">{{ $user->email }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600">No HP</p>
              <p class="text-lg text-slate-900">{{ $user->phone ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600">Tanggal Lahir</p>
              <p class="text-lg text-slate-900">{{ $user->birth_date ?? '-' }}</p>
            </div>
          </div>

          <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
            <p class="text-sm font-semibold text-slate-600">Alamat</p>
            <p class="text-lg text-slate-900">{{ $user->address ?? '-' }}</p>
          </div>
        </div>

        <div class="flex gap-3">
          <a href="{{ route('user.profile.edit') }}"
            class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition flex items-center justify-center gap-2">
            Edit Profil
          </a>

          <button 
            @click="deleteAccountModal = true"
            class="flex-1 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition flex items-center justify-center gap-2"
          >
            Hapus Akun
          </button>
        </div>

        @if (session('success'))
          <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm">{{ session('success') }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div x-show="deleteAccountModal" x-transition
       class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div class="bg-white w-80 p-6 rounded-2xl shadow-xl">
      <h3 class="text-lg font-semibold text-slate-900 text-center">Hapus Akun?</h3>
      <p class="text-slate-600 text-sm mt-2 text-center">
        Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus.
      </p>

      <div class="flex gap-3 mt-6">
        <button @click="deleteAccountModal = false"
                class="flex-1 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
          Batal
        </button>

        <form action="{{ route('user.profile.destroy') }}" method="POST" class="flex-1">
          @csrf
          @method('DELETE')
          <button class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Hapus
          </button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
