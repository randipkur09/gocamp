@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen pt-20 pb-10">
  <div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
      <div class="text-5xl mb-4">📱</div>
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Verifikasi OTP</h1>
      <p class="text-gray-500 mt-2">Kami telah mengirim kode OTP ke email Anda</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
      @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        {{-- OTP Code Field --}}
        <div>
          <label class="block text-gray-700 font-semibold text-sm mb-2">Kode OTP</label>
          <input 
            type="text" 
            name="otp" 
            class="w-full px-4 py-3 border border-cyan-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition text-center text-2xl tracking-widest font-semibold"
            placeholder="000000"
            maxlength="6"
            required
          >
          @error('otp')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Verify Button --}}
        <button 
          type="submit"
          class="w-full py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-200 transition duration-200 transform hover:scale-105"
        >
          Verifikasi
        </button>
      </form>

      {{-- Resend Link --}}
      <p class="text-center text-gray-500 text-sm mt-6">
        Tidak menerima kode?
        <a href="/forgot-password" class="text-cyan-500 font-semibold hover:text-cyan-600 transition">
          Kirim ulang
        </a>
      </p>
    </div>
  </div>
</div>
@endsection
