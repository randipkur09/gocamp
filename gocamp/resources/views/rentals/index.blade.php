@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">Daftar Penyewaan</h2>

<a href="{{ route('rentals.create') }}" class="btn btn-custom mb-3">+ Tambah Sewa</a>

<div class="card p-3">
    <table class="table table-hover align-middle">
        <thead class="table-success">
            <tr>
                <th>#</th>
                <th>Nama Penyewa</th>
                <th>Item</th>
                <th>Tanggal Sewa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Zidan</td>
                <td>Tenda Dome</td>
                <td>27 Okt 2025</td>
                <td><span class="badge bg-success">Aktif</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-success">Detail</button>
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
