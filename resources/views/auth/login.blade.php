@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center text-success fw-bold">Login GoCamp</h3>

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

        <p class="mt-3 text-center">
          Belum punya akun? <a href="/register">Daftar</a>
        </p>
      </form>
    </div>
  </div>
</div>

{{-- Script SweetAlert2 untuk notifikasi sukses --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // Hapus session agar pesan tidak muncul lagi setelah reload
    fetch("{{ route('session.clear.account_deleted') }}", { method: 'POST', headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }});
  });
</script>
@endif
@endsection
