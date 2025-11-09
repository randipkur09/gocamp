@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Transaksi Penyewaan</h2>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Jika tidak ada transaksi --}}
    @if($rentals->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki transaksi penyewaan.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Durasi (hari)</th>
                        <th>Total Harga</th>
                        <th>Tanggal Sewa</th>
                        <th>Status</th>
                        <th>Bukti Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($rentals as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->product->name }}</td>
                            <td>{{ $r->days }} hari</td>
                            <td>Rp{{ number_format($r->total_price, 0, ',', '.') }}</td>
                            <td>{{ $r->created_at->format('d M Y') }}</td>
                            <td>
                                @if($r->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                @elseif($r->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($r->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($r->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($r->payment_proof)
                                    <a href="{{ asset('storage/' . $r->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $r->payment_proof) }}" alt="Bukti Pembayaran" width="80" class="rounded border">
                                    </a>
                                @else
                                    <span class="text-muted">Belum diupload</span>
                                @endif
                            </td>
                            <td>
                                {{-- Jika belum upload bukti pembayaran --}}
                                @if(!$r->payment_proof)
                                    <form action="{{ route('user.uploadPayment', $r->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <input type="file" name="payment_proof" class="form-control form-control-sm" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            Upload Bukti
                                        </button>
                                    </form>
                                @else
                                    <small class="text-success d-block">Sudah diupload</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
