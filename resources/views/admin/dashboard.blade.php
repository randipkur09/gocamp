@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="fw-bold text-success">Dashboard Admin</h2>
  <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Tambah Produk</a>
</div>

<!-- Kartu Statistik -->
<div class="row g-4">
  <div class="col-md-3">
    <div class="card text-center p-3 shadow-sm border-0" style="background:#1B5E20;color:white;">
      <h6>Total Produk</h6>
      <h3>{{ $products->count() }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center p-3 shadow-sm border-0">
      <h6>Total Penyewa</h6>
      <h3 class="text-success">{{ $renters ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center p-3 shadow-sm border-0">
      <h6>Transaksi Hari Ini</h6>
      <h3 class="text-success">{{ $transactionsToday ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center p-3 shadow-sm border-0">
      <h6>Pendapatan (Rp)</h6>
      <h3 class="text-success">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h3>
    </div>
  </div>
</div>

<!-- Daftar Produk -->
<div class="mt-5">
  <h4 class="fw-bold mb-3 text-success">Daftar Produk</h4>
  @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped table-hover align-middle shadow-sm">
    <thead class="table-success">
      <tr>
        <th>#</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Gambar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $p)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->name }}</td>
        <td>Rp {{ number_format($p->price, 0, ',', '.') }}/hari</td>
        <td>{{ ucfirst($p->category ?? '-') }}</td>
        <td>
          @if($p->image)
            <img src="{{ asset('storage/' . $p->image) }}" width="70" class="rounded">
          @else
            <span class="text-muted">Tidak ada</span>
          @endif
        </td>
        <td>
          <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-success">Edit</a>
          <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center text-muted">Belum ada produk camping yang terdaftar.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
