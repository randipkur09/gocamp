@extends('layouts.app')

@section('content')
<h3 class="fw-bold text-success mb-4">Edit Produk</h3>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Harga (Rp / Hari)</label>
        <input type="number" name="price_per_day" value="{{ $product->price_per_day }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ old('stok', $product->stok) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar</label>

        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" width="120" class="d-block mb-2 rounded shadow-sm">
        @endif

        <input type="file" name="image" class="form-control">
        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Update
        </button>
    </div>
</form>
@endsection
