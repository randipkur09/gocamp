<!DOCTYPE html>
<html>
<head>
  <title>GoCamp</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #1B5E20;
    }
    .navbar-brand, .nav-link, .btn {
      color: white !important;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">GoCamp</a>
      <a href="/logout" class="btn btn-light btn-sm">Logout</a>
    </div>
  </nav>
  <div class="container mt-5">
    @yield('content')
  </div>
</body>
</html>
