@extends('layouts.app')

@section('content')

<h2 class="fw-bold text-success mb-4">Daftar Transaksi Penyewaan</h2>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<table class="table table-hover table-bordered align-middle">
  <thead class="table-success">
    <tr class="text-center">
      <th>#</th>
      <th>Nama User</th>
      <th>Produk</th>
      <th>Durasi (hari)</th>
      <th>Total Harga</th>
      <th>Bukti Pembayaran</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($rentals as $r)
    <tr>
      <td class="text-center">{{ $loop->iteration }}</td>
      <td>{{ $r->user->name }}</td>
      <td>{{ $r->product->name }}</td>
      <td class="text-center">{{ $r->days }}</td>
      <td>Rp {{ number_format($r->total_price, 0, ',', '.') }}</td>

      {{-- Bukti Pembayaran --}}
      <td class="text-center">
        @if($r->payment_proof)
          <a href="{{ asset('storage/' . $r->payment_proof) }}" target="_blank" class="btn btn-outline-success btn-sm">
            Lihat Bukti
          </a>
        @else
          <span class="text-muted">Belum Upload</span>
        @endif
      </td>

      {{-- Status --}}
      <td class="text-center">
        <span class="badge 
          @if($r->status == 'pending') bg-warning 
          @elseif($r->status == 'approved') bg-success 
          @elseif($r->status == 'returned') bg-secondary 
          @else bg-dark @endif">
          {{ ucfirst($r->status) }}
        </span>
      </td>

      {{-- Aksi --}}
      <td class="text-center">
        {{-- Approve --}}
        @if($r->status == 'pending')
          <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success btn-sm mb-1 w-100">
              <i class="bi bi-check-circle"></i> Approve
            </button>
          </form>
        @endif

        {{-- Return --}}
        @if($r->status == 'approved')
          <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="returned">
            <button type="submit" class="btn btn-secondary btn-sm mb-1 w-100">
              <i class="bi bi-box-arrow-left"></i> Return
            </button>
          </form>
        @endif

        {{-- Delete --}}
        <form action="{{ route('admin.rentals.destroy', $r->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm w-100">
            <i class="bi bi-trash"></i> Hapus
          </button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
