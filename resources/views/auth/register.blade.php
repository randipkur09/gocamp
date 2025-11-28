@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pt-20 pb-10">
  <div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="text-5xl mb-4">🏕️</div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Buat Akun GoCamp</h1>
      <p class="text-gray-500 mt-2">Bergabunglah dengan ribuan penggemar camping</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
      <form method="POST" action="/register" class="space-y-4">
        @csrf

        {{-- Full Name Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Nama Lengkap</label>
          <input 
            type="text" 
            name="name" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            value="{{ old('name') }}"
            required
            placeholder="Nama Anda"
          >
          @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Email Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
          <input 
            type="email" 
            name="email" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            value="{{ old('email') }}"
            required
            placeholder="nama@email.com"
          >
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Password Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Password</label>
          <input 
            type="password" 
            name="password" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            required
            placeholder="Minimal 8 karakter"
          >
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Password Confirmation Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Konfirmasi Password</label>
          <input 
            type="password" 
            name="password_confirmation" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            required
            placeholder="Ulangi password"
          >
          @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Register Button --}}
        <button 
          type="submit"
          class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-200 transition duration-200 transform hover:scale-105 mt-6"
        >
          Daftar Sekarang
        </button>
      </form>

      {{-- Divider --}}
      <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-cyan-100"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-3 bg-white text-gray-500">atau</span>
        </div>
      </div>

      {{-- Login Link --}}
      <p class="text-center text-gray-600">
        Sudah punya akun?
        <a href="/login" class="text-cyan-500 font-semibold hover:text-cyan-600 transition">
          Login di sini
        </a>
      </p>
    </div>
  </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });
    });
  </script>
@endif

@if (session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'error',
        title: 'Registrasi Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#00bcd4'
      });
    });
  </script>
@endif
@endsection
