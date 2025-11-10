<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoCamp</title>

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    main {
      flex: 1;
      padding-top: 60px;
      padding-bottom: 40px;
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

    .notification-bell {
      position: relative;
      color: white;
      font-size: 1.25rem;
      cursor: pointer;
    }

    .notification-bell .badge {
      position: absolute;
      top: 0;
      right: -6px;
      background-color: red;
      color: white;
      font-size: 0.65rem;
      border-radius: 50%;
      padding: 3px 5px;
    }

    footer {
      background-color: #1B5E20;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: auto;
    }
  </style>
</head>

<body>
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/">GoCamp</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

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

            {{-- Notifikasi Admin --}}
            @if(Auth::user()->role == 'admin')
              <li class="nav-item dropdown mx-3">
                <a class="nav-link dropdown-toggle notification-bell" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
                  <i class="bi bi-bell"></i>
                  @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                  @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="width: 280px; max-height: 300px; overflow-y: auto;">
                  <li class="dropdown-header fw-bold text-center">Notifikasi</li>
                  @forelse(Auth::user()->notifications as $notification)
                    <li>
                      <a class="dropdown-item small {{ $notification->read_at ? '' : 'fw-bold text-success' }}" href="#">
                        {{ $notification->data['message'] ?? 'Transaksi baru masuk.' }}
                        <div class="text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                      </a>
                    </li>
                  @empty
                    <li><p class="dropdown-item text-center text-muted small mb-0">Tidak ada notifikasi</p></li>
                  @endforelse
                </ul>
              </li>
            @endif

            {{-- Dropdown user --}}
            <li class="nav-item dropdown ms-2">
              <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                @if(Auth::user()->role == 'user')
                  <li><a class="dropdown-item" href="{{ route('user.profile.show') }}">Profil Saya</a></li>
                  <li><hr class="dropdown-divider"></li>
                @endif
                <li>
                  <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Logout
                  </button>
                </li>
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
  <main class="container">
    @yield('content')
  </main>

  {{-- Footer sticky --}}
  <footer>
    <p class="mb-0">© {{ date('Y') }} GoCamp. All Rights Reserved.</p>
    <small>Sewa alat camping terbaik di Indonesia</small>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Modal Logout --}}
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-3 shadow-lg">
        <div class="modal-header bg-success text-white rounded-top-3">
          <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <p>Apakah Anda yakin ingin keluar dari akun?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger px-4">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
