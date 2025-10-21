<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Publish Zakat')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      background-color: #0d6efd;
    }
    .navbar-brand {
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .navbar-brand:hover {
      color: #f8f9fa;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .section-title {
      font-weight: 600;
      color: #0d6efd;
      margin-top: 40px;
      margin-bottom: 20px;
      text-transform: uppercase;
      border-bottom: 3px solid #0d6efd;
      display: inline-block;
      padding-bottom: 5px;
    }
    footer {
      margin-top: 50px;
      background: #0d6efd;
      color: white;
      text-align: center;
      padding: 15px 0;
      border-radius: 10px 10px 0 0;
    }
  </style>
</head>
<body>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Sistem Zakat</a>
    </div>
  </nav>

  {{-- Konten --}}
  <div class="container py-5">
    @yield('content')
  </div>

  {{-- Footer --}}
  <footer>
    <p>© 2025 Sistem Informasi Zakat | Halaman Publish</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
