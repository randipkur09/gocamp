@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" 
     style="min-height: calc(100vh - 120px); margin-top: 40px;">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center text-success fw-bold mb-4">Login GoCamp</h3>

      {{-- Form Login --}}
      <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input id="email" type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn w-100" style="background:#1B5E20;color:white;">Login</button>

        <p class="mt-2 text-center">
          <a href="/forgot-password" class="text-success fw-bold">Lupa Password?</a>
        </p>

        <p class="mt-3 text-center">
          Belum punya akun?
          <a href="/register" class="text-success fw-bold">Daftar di sini</a>
        </p>
      </form>
    </div>
  </div>
</div>

{{-- Script SweetAlert2 untuk notifikasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Notifikasi Berhasil Daftar --}}
@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 2000
    });
  });
</script>
@endif

{{-- Notifikasi Akun Berhasil Dihapus --}}
@if (session('account_deleted'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Akun Berhasil Dihapus!',
      text: 'Akun Anda telah dihapus dengan sukses.',
      showConfirmButton: false,
      timer: 2000
    });

    fetch("{{ route('session.clear.account_deleted') }}", { 
      method: 'POST', 
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
    });
  });
</script>
@endif
@endsection
