<!DOCTYPE html>
<html lang="id" x-data="{ showLogoutModal: false }" x-cloak>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoCamp</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    [x-cloak]{display:none!important}
    * { font-family:'Outfit',sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-cyan-50 min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="bg-white border-b border-cyan-200 shadow-sm fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Logo GoCamp -->
        <a href="@auth {{ auth()->user()->role==='admin'?route('admin.dashboard'):route('user.dashboard') }} @else {{ route('login') }} @endauth"
          class="text-2xl font-bold bg-gradient-to-r from-cyan-500 to-blue-600 bg-clip-text text-transparent flex items-center gap-2">
          GoCamp
        </a>

        <!-- Hamburger menu -->
        <button x-data="{ open:false }" @click="open=!open" class="md:hidden text-gray-600 hover:text-cyan-500 transition">
          <i x-show="!open" class="bi bi-list text-xl"></i>
          <i x-show="open" class="bi bi-x text-xl"></i>
        </button>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-1">
          @auth
            @if(auth()->user()->role=='admin')
              <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Dashboard</a>
              @if(Route::has('admin.products.index'))
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Produk</a>
              @endif
              @if(Route::has('admin.rentals'))
                <a href="{{ route('admin.rentals') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Transaksi</a>
              @endif
            @else
              <a href="{{ route('user.dashboard') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Dashboard</a>
              @if(Route::has('user.rentals'))
                <a href="{{ route('user.rentals') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Sewa Saya</a>
              @endif
            @endif

            <!-- User Dropdown -->
            <div x-data="{ userOpen:false }" class="ml-6 relative">
              <button @click="userOpen=!userOpen" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">
                {{ Auth::user()->name }} <i class="bi bi-chevron-down text-sm"></i>
              </button>

              <div x-show="userOpen" @click.outside="userOpen=false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-cyan-100 overflow-hidden z-40">
                <a href="{{ auth()->user()->role==='admin' && Route::has('admin.dashboard') ? route('admin.dashboard') : route('user.profile.show') }}" class="block px-4 py-3 hover:bg-cyan-50">Profil Saya</a>
                <div class="border-t"></div>
                <button @click="showLogoutModal=true; userOpen=false" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">
                  <i class="bi bi-box-arrow-right mr-2"></i>Logout
                </button>
              </div>
            </div>

          @else
            <a href="{{ route('login') }}" class="px-4 py-2 hover:text-cyan-500 hover:bg-cyan-50 rounded-lg">Login</a>
            <a href="{{ route('register') }}" class="ml-2 px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-lg">Daftar</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-10">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-cyan-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">
      <p class="text-gray-800 font-semibold">© {{ date('Y') }} GoCamp</p>
      <p class="text-gray-500 text-sm mt-2">Nikmati pengalaman camping terbaik</p>
    </div>
  </footer>

  <!-- Logout Form -->
  <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

  <!-- Logout Modal -->
  <div x-show="showLogoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
    <div class="bg-white rounded-2xl shadow-2xl w-96 overflow-hidden">
      <div class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white p-6">
        <h2 class="text-xl font-bold">Konfirmasi Logout</h2>
      </div>
      <div class="p-6 text-center">
        <p>Apakah Anda yakin ingin keluar?</p>
      </div>
      <div class="flex gap-3 p-6 border-t justify-center">
        <button @click="showLogoutModal=false" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
        <button @click="document.getElementById('logoutForm').submit()" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-lg">Logout</button>
      </div>
    </div>
  </div>

</body>
</html>
