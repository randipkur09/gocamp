@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pt-20 pb-10">
  <div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="text-5xl mb-4">🔑</div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Lupa Password?</h1>
      <p class="text-gray-500 mt-2">Masukkan email Anda untuk menerima kode OTP</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
      @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('forgot.send') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Email Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
          <input 
            type="email" 
            name="email" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
            required
            placeholder="nama@email.com"
          >
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Submit Button --}}
        <button 
          type="submit"
          class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-200 transition duration-200 transform hover:scale-105"
        >
          Kirim OTP
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

      {{-- Back to Login Link --}}
      <p class="text-center text-gray-600">
        Ingat password Anda?
        <a href="/login" class="text-cyan-500 font-semibold hover:text-cyan-600 transition">
          Login sekarang
        </a>
      </p>
    </div>
  </div>
</div>
@endsection
