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

    .navbar-brand, .nav-link {
      color: white !important;
      font-weight: 600;
    }

    .btn {
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }

    .btn:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }

    .card {
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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
      <a class="navbar-brand fw-bold" href="/">GoCamp</a>
      
      {{-- Tombol collapse di mobile --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          @auth
            @if(Auth::user()->role == 'admin')
              <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard Admin</a></li>
            @else
              <li class="nav-item"><a class="nav-link" href="/user/dashboard">Dashboard</a></li>
            @endif
            <li class="nav-item">
              <a href="/logout" class="btn btn-light btn-sm ms-3">Logout</a>
            </li>
          @endauth
          @auth
    @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.rentals') }}">Transaksi</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.rentals') }}">Sewa Saya</a>
        </li>
    @endif
@endauth


          @guest
            <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
          @endguest
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
    <small>Sewa alat camping terbaik di Indonesia 🌿</small>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
