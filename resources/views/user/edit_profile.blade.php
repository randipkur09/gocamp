@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm border-0 rounded-4">
    
    {{-- Header --}}
    <div class="card-header bg-success text-white text-center rounded-top-4">
      <h4 class="mb-0">Edit Profil Saya</h4>
    </div>

    {{-- Body --}}
    <div class="card-body p-4">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Lengkap --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lengkap</label>
          <input type="text" name="name" class="form-control rounded-3" 
                 value="{{ old('name', $user->name) }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" name="email" class="form-control rounded-3"
                 value="{{ old('email', $user->email) }}" required>
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Nomor HP</label>
          <input type="text" name="phone" class="form-control rounded-3" 
                 value="{{ old('phone', $user->phone) }}">
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Alamat</label>
          <textarea name="address" rows="2" class="form-control rounded-3">{{ old('address', $user->address) }}</textarea>
        </div>

        {{-- Tanggal Lahir --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Tanggal Lahir</label>
          <input type="date" name="birth_date" class="form-control rounded-3"
                 value="{{ old('birth_date', $user->birth_date) }}">
        </div>

        {{-- Foto Profil --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Foto Profil</label>
          <input type="file" name="photo" class="form-control rounded-3">
          @if($user->photo)
            <div class="mt-2">
              <img src="{{ asset('storage/photos/'.$user->photo) }}" width="90" class="rounded shadow-sm border">
            </div>
          @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="text-end mt-4">
          <a href="{{ route('user.profile.show') }}" class="btn btn-secondary rounded-3 px-4">Batal</a>
          <button type="submit" class="btn btn-success rounded-3 px-4 ms-2">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
