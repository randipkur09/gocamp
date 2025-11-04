@extends('layouts.app')

@section('content')
<h3 class="fw-bold text-success mb-4">Edit Produk</h3>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga (Rp)</label>
        <input type="number" name="price" value="{{ $product->price }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ $product->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Gambar</label>
        @if($product->image)
            <img src="{{ asset('images/'.$product->image) }}" width="100" class="d-block mb-2">
        @endif
        <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
