@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
      <!-- Header -->
      <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-8">
        <h2 class="text-3xl font-bold text-white">Profil Saya</h2>
      </div>

      <!-- Body -->
      <div class="p-8">
        <!-- Profile Photo & Name -->
        <div class="text-center mb-8">
          <img 
            src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&w=400&h=400&fit=crop' }}" 
            alt="Foto Profil"
            class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-cyan-200 shadow-lg mb-4"
          >
          <h3 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h3>
        </div>

        <!-- Profile Information -->
        <div class="space-y-4 mb-8">
          <!-- Profile Info Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600 mb-1">Nama Lengkap</p>
              <p class="text-lg text-slate-900">{{ $user->name ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600 mb-1">Email</p>
              <p class="text-lg text-slate-900 break-all">{{ $user->email ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600 mb-1">No HP</p>
              <p class="text-lg text-slate-900">{{ $user->phone ?? '-' }}</p>
            </div>

            <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
              <p class="text-sm font-semibold text-slate-600 mb-1">Tanggal Lahir</p>
              <p class="text-lg text-slate-900">{{ $user->birth_date ?? '-' }}</p>
            </div>
          </div>

          <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
            <p class="text-sm font-semibold text-slate-600 mb-1">Alamat</p>
            <p class="text-lg text-slate-900">{{ $user->address ?? '-' }}</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
          <a 
            href="{{ route('user.profile.edit') }}"
            class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200 text-center flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profil
          </a>

          <button 
            onclick="deleteAccountModal = true"
            class="flex-1 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all duration-200 flex items-center justify-center gap-2"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus Akun
          </button>
        </div>

        <!-- Success Message -->
        @if (session('success'))
          <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm">{{ session('success') }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div x-show="deleteAccountModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div x-show="deleteAccountModal" @click="deleteAccountModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

      <div x-show="deleteAccountModal" class="inline-block align-bottom bg-white rounded-2xl shadow-xl transform transition-all max-w-sm w-full">
        <div class="bg-white px-6 py-6 rounded-2xl">
          <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Akun?</h3>
            <p class="text-slate-600 text-sm mb-6">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.</p>
          </div>

          <div class="flex gap-3">
            <button 
              @click="deleteAccountModal = false"
              class="flex-1 py-2 border-2 border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition-colors"
            >
              Batal
            </button>
            <form action="{{ route('user.profile.destroy') }}" method="POST" class="flex-1">
              @csrf
              @method('DELETE')
              <button 
                type="submit"
                class="w-full py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors"
              >
                Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    Alpine.store('modal', {
      deleteAccountModal: false
    })
  </script>
</div>
@endsection
