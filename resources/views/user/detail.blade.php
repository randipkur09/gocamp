@extends('layouts.app')

@section('content')
<div class="card shadow-lg border-0 rounded-4">
  <div class="row g-0">
    <div class="col-md-6">
      <img src="{{ asset('images/' . $product->image) }}" 
           class="img-fluid rounded-start-4" 
           style="height: 100%; object-fit: cover;">
    </div>

    <div class="col-md-6 p-4">
      <h3 class="fw-bold text-success">{{ $product->name }}</h3>
      <p class="text-muted">{{ $product->description }}</p>

      <h5 class="text-dark mt-4">
        Harga Sewa: 
        <span class="fw-bold text-success">
          Rp {{ number_format($product->price, 0, ',', '.') }} / hari
        </span>
      </h5>

      {{-- FORM PEMESANAN --}}
      <form action="{{ route('rent.store') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="mb-3">
          <label for="days" class="form-label fw-semibold">Lama Sewa (hari)</label>
          <input type="number" name="days" id="days" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success w-100 rounded-pill">
          Sewa Sekarang
        </button>
      </form>

      <a href="{{ route('user.dashboard') }}" 
         class="btn btn-outline-secondary mt-2 w-100 rounded-pill">
         Kembali
      </a>
    </div>
  </div>
</div>
@endsection