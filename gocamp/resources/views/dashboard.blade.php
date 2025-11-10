@extends('layouts.app')

@section('body-class', 'dashboard-page')

@section('content')
<div class="hero mb-5" data-aos="fade-up">
    <h1 class="fw-bold display-5">Selamat Datang di <span style="color:#90ee90;">GoCamp</span></h1>
    <p class="lead mt-3">Petualanganmu dimulai di sini. Sewa perlengkapan camping terbaik dengan mudah dan cepat.</p>
    <a href="#" class="btn btn-custom mt-3 px-4 py-2">Mulai Sewa Sekarang</a>
</div>

<div class="row text-center" data-aos="fade-up">
    <div class="col-md-4 mb-3">
        <div class="card p-4">
            <h4>Peralatan Lengkap</h4>
            <p>Semua kebutuhan camping tersedia, dari tenda hingga sepatu gunung.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-4">
            <h4>Harga Terjangkau</h4>
            <p>Dapatkan harga sewa terbaik untuk setiap peralatan.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-4">
            <h4>Pelayanan Cepat</h4>
            <p>Booking online dan konfirmasi hanya dalam hitungan menit.</p>
        </div>
    </div>
</div>
@endsection
