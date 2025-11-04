@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow p-4">
      <h3 class="text-center text-success fw-bold">Login GoCamp</h3>
      <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn w-100" style="background:#1B5E20;color:white;">Login</button>
        <p class="mt-3 text-center">Belum punya akun? <a href="/register">Daftar</a></p>
      </form>
    </div>
  </div>
</div>
@endsection
