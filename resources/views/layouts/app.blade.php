<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoCamp</title>

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #1B5E20;
    }

    .navbar-brand {
      color: white !important;
      font-weight: 700;
      font-size: 1.25rem;
    }

    .nav-link {
      color: white !important;
      font-weight: 500;
      margin-left: 15px;
    }

    .nav-link:hover {
      color: #C8E6C9 !important;
    }

    .dropdown-menu {
      font-size: 0.9rem;
    }

    footer {
      background-color: #1B5E20;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 80px;
    }
  </style>
</head>

<body>
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
      {{-- Logo kiri --}}
      <a class="navbar-brand fw-bold" href="/">GoCamp</a>

      {{-- Tombol toggle untuk mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Menu kanan --}}
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          @auth
            @if(Auth::user()->role == 'admin')
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Produk</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.rentals') }}">Transaksi</a></li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('user.rentals') }}">Sewa Saya</a></li>
            @endif

            {{-- Dropdown user --}}
            <li class="nav-item dropdown ms-3">
              <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
              </ul>
            </li>
          @else
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- Konten utama --}}
  <div class="container mt-5">
    @yield('content')
  </div>

  {{-- Footer --}}
  <footer>
    <p class="mb-0">© {{ date('Y') }} GoCamp. All Rights Reserved.</p>
    <small>Sewa alat camping terbaik di Indonesia</small>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
