@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Edit Profile Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
      <!-- Header -->
      <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-8">
        <h2 class="text-3xl font-bold text-white">Edit Profil Saya</h2>
      </div>

      <!-- Body -->
      <div class="p-8">
        <!-- Success Alert -->
        @if(session('success'))
          <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm font-semibold">{{ session('success') }}</p>
          </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Name Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input 
              type="text" 
              name="name" 
              value="{{ old('name', $user->name) }}" 
              required
              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
            >
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <!-- Email Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input 
              type="email" 
              name="email" 
              value="{{ old('email', $user->email) }}" 
              required
              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
            >
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
          </div>

          <!-- Phone Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
            <input 
              type="text" 
              name="phone" 
              value="{{ old('phone', $user->phone) }}"
              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
            >
          </div>

          <!-- Address Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
            <textarea 
              name="address" 
              rows="3"
              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
            >{{ old('address', $user->address) }}</textarea>
          </div>

          <!-- Birth Date Field -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
            <input 
              type="date" 
              name="birth_date" 
              value="{{ old('birth_date', $user->birth_date) }}"
              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
            >
          </div>

          <!-- Photo Upload -->
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Profil</label>
            <div class="relative">
              <input 
                type="file" 
                name="photo" 
                accept="image/*"
                class="w-full px-4 py-3 border-2 border-dashed border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all cursor-pointer"
              >
              <p class="text-sm text-slate-500 mt-2">JPG, PNG, GIF (Max 5MB)</p>
            </div>

            @if($user->photo)
              <div class="mt-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
                <p class="text-sm font-semibold text-slate-700 mb-2">Foto Saat Ini</p>
                <img 
                  src="{{ asset('storage/' . $user->photo) }}" 
                  alt="Foto Profil"
                  class="w-32 h-32 object-cover rounded-lg border border-slate-300"
                >
              </div>
            @endif
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-3 pt-4">
            <a 
              href="{{ route('user.profile.show') }}"
              class="flex-1 py-3 border-2 border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition-colors text-center"
            >
              Batal
            </a>
            <button 
              type="submit"
              class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200"
            >
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
