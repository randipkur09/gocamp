@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-success">Kelola Produk Camping</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Tambah Produk</a>
</div>

{{-- Notifikasi sukses --}}
@if(session('success'))
    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sukses!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        // Otomatis hilang setelah 3 detik
        setTimeout(() => {
            const alert = document.getElementById('alert-success');
            if (alert) alert.style.display = 'none';
        }, 3000);
    </script>
@endif

<table class="table table-striped table-bordered align-middle">
    <thead class="table-success">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->name }}</td>
            <td>Rp {{ number_format($p->price_per_day, 0, ',', '.') }}</td>
            <td>{{ $p->stok ?? '0' }}</td>
            <td>
                @if($p->image)
                    {{-- ambil gambar dari storage --}}
                    <img src="{{ asset('storage/'.$p->image) }}" alt="gambar {{ $p->name }}" width="70" class="rounded">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">Belum ada produk tersedia</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
