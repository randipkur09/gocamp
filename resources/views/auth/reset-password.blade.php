@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pt-20 pb-10">
  <div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="text-5xl mb-4">🔐</div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Reset Password</h1>
      <p class="text-gray-500 mt-2">Buat password baru yang kuat dan aman</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
      <form action="{{ route('reset.submit') }}" method="POST" class="space-y-5">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        {{-- New Password Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Password Baru</label>
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

        {{-- Confirm Password Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Konfirmasi Password</label>
          <input 
            type="password" 
            name="password_confirmation" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            required
            placeholder="Ulangi password baru"
          >
          @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Reset Button --}}
        <button 
          type="submit"
          class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-200 transition duration-200 transform hover:scale-105 mt-6"
        >
          Reset Password
        </button>
      </form>

      {{-- Back to Login Link --}}
      <p class="text-center text-gray-600 text-sm mt-6">
        <a href="/login" class="text-cyan-500 font-semibold hover:text-cyan-600 transition">
          Kembali ke Login
        </a>
      </p>
    </div>
  </div>
</div>
@endsection
