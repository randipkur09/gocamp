@extends('layouts.app')
@section('content')

<div class="text-center mb-5">
  <h2 class="fw-bold text-success">Selamat Datang di GoCamp!</h2>
  <p class="text-muted">Temukan peralatan camping terbaik untuk petualanganmu 🌲</p>
</div>

<div class="row g-4">
  @forelse($products as $p)
  <div class="col-md-4">
    <div class="card h-100 shadow-sm border-0">
      <img src="{{ asset('storage/' . $p->image) }}" class="card-img-top" alt="{{ $p->name }}">
      <div class="card-body">
        <h5 class="fw-bold">{{ $p->name }}</h5>
        <p class="text-success fw-semibold">Rp {{ number_format($p->price, 0, ',', '.') }}/hari</p>
        <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#productModal{{ $p->id }}">
          Lihat Detail
        </button>
      </div>
    </div>
  </div>

  {{-- Modal Detail Produk --}}
  <div class="modal fade" id="productModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#1B5E20;color:white;">
          <h5 class="modal-title">{{ $p->name }}</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <img src="{{ asset('storage/' . $p->image) }}" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
              <h5 class="text-success fw-bold">Rp {{ number_format($p->price, 0, ',', '.') }}/hari</h5>
              <p class="mt-3">{{ $p->description ?? 'Tidak ada deskripsi' }}</p>

              {{-- 🔰 Form Penyewaan --}}
              <form action="{{ route('rent.store', $p->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="days" class="form-label">Durasi Sewa (hari)</label>
                  <input type="number" name="days" class="form-control" min="1" value="1" required>
                </div>
                <button class="btn btn-success w-100 mt-2">Sewa Sekarang</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="text-center text-muted">
    <p>Belum ada produk yang tersedia saat ini.</p>
  </div>
  @endforelse
</div>

@endsection
