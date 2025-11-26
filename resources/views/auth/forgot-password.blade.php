@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center fw-bold text-success mb-3">Lupa Password</h3>

      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form action="{{ route('forgot.send') }}" method="POST">
        @csrf
        <label>Email</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <button class="btn w-100" style="background:#1B5E20;color:white;">Kirim OTP</button>
      </form>
    </div>
  </div>
</div>
@endsection
