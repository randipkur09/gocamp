@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center text-success fw-bold">Daftar Akun GoCamp</h3>

      {{-- Notifikasi sukses atau error --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Form Registrasi --}}
      <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn w-100" style="background:#1B5E20; color:white;">Daftar Sekarang</button>

        <p class="mt-3 text-center">
          Sudah punya akun?
          <a href="/login" class="text-success fw-bold">Login di sini</a>
        </p>
      </form>
    </div>
  </div>
</div>
@endsection
