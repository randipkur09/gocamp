@extends('layouts.app')

@section('content')
<h3 class="fw-bold text-success mb-4">Tambah Produk Baru</h3>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-control" placeholder="Masukkan nama produk" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Harga (Rp / Hari)</label>
        <input type="number" name="price_per_day" class="form-control" placeholder="Contoh: 35000" required>

    </div>

    <div class="mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stok" class="form-control" placeholder="Jumlah stok tersedia" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan deskripsi produk..."></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan
        </button>
    </div>
</form>
@endsection
