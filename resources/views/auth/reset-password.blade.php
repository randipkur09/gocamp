@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center fw-bold text-success mb-3">Reset Password</h3>

      <form action="{{ route('reset.submit') }}" method="POST">
        @csrf

        <input type="hidden" name="email" value="{{ session('email') }}">

        <label>Password Baru</label>
        <input type="password" name="password" class="form-control mb-3" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control mb-3" required>

        <button class="btn w-100" style="background:#1B5E20;color:white;">Reset Password</button>
      </form>
    </div>
  </div>
</div>
@endsection
