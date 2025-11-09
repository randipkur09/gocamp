@extends('layouts.app')
@section('content')

<h2 class="fw-bold text-success mb-4">Daftar Transaksi Penyewaan</h2>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-hover table-bordered align-middle">
  <thead class="table-success">
    <tr>
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
      <td>{{ $loop->iteration }}</td>
      <td>{{ $r->user->name }}</td>
      <td>{{ $r->product->name }}</td>
      <td>{{ $r->days }}</td>
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
      <td>
        <span class="badge 
          @if($r->status == 'pending') bg-warning 
          @elseif($r->status == 'approved') bg-success 
          @elseif($r->status == 'returned') bg-secondary 
          @else bg-dark @endif">
          {{ ucfirst($r->status) }}
        </span>
      </td>

      {{-- Aksi --}}
      <td>
        @if($r->status == 'pending')
          <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="approved">
            <button class="btn btn-success btn-sm">Approve</button>
          </form>
        @elseif($r->status == 'approved')
          <form action="{{ route('admin.rentals.update', $r->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="returned">
            <button class="btn btn-secondary btn-sm">Return</button>
          </form>
        @else
          <span class="text-muted">Selesai</span>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
