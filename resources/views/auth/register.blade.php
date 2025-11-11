@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 40px; min-height: 90vh;">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow p-4">
        <h3 class="text-center text-success fw-bold mb-4">Daftar Akun GoCamp</h3>

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
</div>

{{-- Script SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Notifikasi pop-up SweetAlert --}}
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
      confirmButtonColor: '#1B5E20'
    });
  });
</script>
@endif
@endsection
