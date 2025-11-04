@extends('layouts.app')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="row g-0">
    <div class="col-md-6">
      <img src="{{ asset('images/' . $product->image) }}" class="img-fluid rounded-start-4" style="height: 100%; object-fit: cover;">
    </div>
    <div class="col-md-6 p-4">
      <h3 class="fw-bold text-success">{{ $product->name }}</h3>
      <p class="text-muted">{{ $product->description }}</p>
      <h5 class="text-dark mt-4">Harga Sewa: <span class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }} / hari</span></h5>
      <button class="btn btn-success mt-3 w-100 rounded-pill">Sewa Sekarang</button>
      <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary mt-2 w-100 rounded-pill">Kembali</a>
    </div>
  </div>
</div>
@endsection
