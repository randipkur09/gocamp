<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoCamp</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/gocamp.css') }}">
</head>
<body class="@yield('body-class') d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Logo GoCamp -->
        <a class="navbar-brand fw-bold" href="
            @auth
                @if(auth()->user()->role === 'admin')
                    {{ route('admin.dashboard') }}
                @else
                    {{ route('user.dashboard') }}
                @endif
            @else
                {{ route('home') }}
            @endauth
        ">GoCamp</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.rentals.index') }}">Transaksi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.profile') }}">Profil</a></li>
                        <li class="nav-item ms-2">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-light">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.rentals') }}">Penyewaan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.profile') }}">Profil</a></li>
                        <li class="nav-item ms-2">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-light">Logout</button>
                            </form>
                        </li>
                    @endif
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container py-4">
    @yield('content')
</div>

<!-- Footer -->
<footer class="text-center py-4 bg-light mt-auto">
    <p class="mb-0">© {{ date('Y') }} GoCamp | Petualanganmu Dimulai di Sini 🌲</p>
</footer>

<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/gocamp.js') }}"></script>

<script>
    // Inisialisasi AOS
    AOS.init();
</script>
</body>
</html>
