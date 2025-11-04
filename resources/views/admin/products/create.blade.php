@extends('layouts.app')

@section('content')
<h3 class="fw-bold text-success mb-4">Tambah Produk Baru</h3>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga (Rp)</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Gambar</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
