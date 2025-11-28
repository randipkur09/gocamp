@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pt-20 pb-10">
  <div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="text-5xl mb-4">🏕️</div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Selamat Datang</h1>
      <p class="text-gray-500 mt-2">Masuk ke akun Anda untuk memulai petualangan</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
      <form method="POST" action="/login" class="space-y-5">
        @csrf

        {{-- Email Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
          <input 
            id="email" 
            type="email" 
            name="email" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            value="{{ old('email') }}"
            required 
            autofocus
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
            id="password" 
            type="password" 
            name="password" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            required
            placeholder="Masukkan password Anda"
          >
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Forgot Password Link --}}
        <div class="text-right">
          <a href="/forgot-password" class="text-cyan-500 font-semibold text-sm hover:text-cyan-600 transition">
            Lupa Password?
          </a>
        </div>

        {{-- Login Button --}}
        <button 
          type="submit" 
          class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-200 transition duration-200 transform hover:scale-105"
        >
          Login
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

      {{-- Register Link --}}
      <p class="text-center text-gray-600">
        Belum punya akun?
        <a href="/register" class="text-cyan-500 font-semibold hover:text-cyan-600 transition">
          Daftar sekarang
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
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: '#ffffff',
        customClass: {
          popup: 'rounded-2xl shadow-lg'
        }
      });
    });
  </script>
@endif

@if (session('account_deleted'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        icon: 'success',
        title: 'Akun Berhasil Dihapus!',
        text: 'Akun Anda telah dihapus dengan sukses.',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });

      fetch("{{ route('session.clear.account_deleted') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      });
    });
  </script>
@endif
@endsection
