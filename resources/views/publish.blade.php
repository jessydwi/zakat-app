<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publikasi Zakat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .card:hover {
      transform: translateY(-5px);
      transition: transform 0.3s ease;
    }
    .card {
      min-height: 280px; /* Menambahkan tinggi minimum agar ukuran kotak sama */
    }
    .bg-gradient-green {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%); /* Gradien hijau untuk semua kartu */
    }
    .text-shadow {
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    .btn-custom {
      border-radius: 50px;
      padding: 15px 30px;
      font-size: 1.1rem;
      font-weight: bold;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-custom:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .access-section {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      border-radius: 15px;
      padding: 40px 20px;
      margin-top: 50px;
    }
    .info-item {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .info-item:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .info-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #28a745, #20c997); /* Ubah ke hijau */
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    .info-item:hover::before {
      transform: scaleX(1);
    }
    .quote {
      font-style: italic;
      font-size: 1.2rem;
      color: #555;
      border-left: 5px solid #28a745; /* Ubah ke hijau */
      padding-left: 15px;
      margin: 20px 0;
    }
    .fact-box {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); /* Ubah ke hijau muda */
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      text-align: center;
      color: #333;
    }
    .timeline {
      position: relative;
      padding-left: 30px;
    }
    .timeline::before {
      content: '';
      position: absolute;
      left: 15px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: #28a745; /* Ubah ke hijau */
    }
    .timeline-item {
      position: relative;
      margin-bottom: 20px;
    }
    .timeline-item::before {
      content: '';
      position: absolute;
      left: -22px;
      top: 5px;
      width: 10px;
      height: 10px;
      background: #28a745; /* Ubah ke hijau */
      border-radius: 50%;
    }
    .elegant-text {
      font-family: 'Georgia', serif;
      line-height: 1.6;
      color: #444;
    }
    .carousel-item {
      transition: transform 0.6s ease;
    }
    .animate-fade-in {
      animation: fadeIn 1s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="bg-light">

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
        <i class="bi bi-moon-stars-fill me-2"></i>ZakatApp
      </a>
      <div class="ms-auto">
        <a href="{{ route('publish') }}" class="btn btn-outline-success me-2">
          <i class="bi bi-eye-fill me-1"></i>Halaman Publik
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">
          <i class="bi bi-box-arrow-in-right me-1"></i>Login
        </a>
      </div>
    </div>
  </nav>
  
{{-- Konten Utama --}}
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark display-5" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.1);">
            Publikasi Zakat
        </h2>
        <div class="mx-auto mb-3" style="width: 100px; height: 4px; background: linear-gradient(90deg, #00c6ff, #0072ff); border-radius: 5px;"></div>
        <p class="text-muted fs-5">Rekapan & Informasi Zakat Fitrah, Fidyah, dan Infaq/Shodaqoh</p>
    </div>

      {{-- Rekapan --}}
<div class="row g-4">
    {{-- Zakat Fitrah --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center bg-gradient-green text-white">
            <div class="card-body">
                <i class="bi bi-basket2 display-4 mb-3"></i>
                <h5 class="fw-bold">Rekapan Zakat Fitrah</h5>
                <p>Total Muzakki: <strong>{{ $rekapan['fitrah']['muzakki'] ?? 0 }} Orang</strong></p>
                <p>Total Beras: <strong>{{ $rekapan['fitrah']['beras'] ?? 0 }} Kg</strong></p>
                <p>Total Uang: <strong>Rp {{ number_format($rekapan['fitrah']['uang'] ?? 0, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>

    {{-- Zakat Fidyah --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center bg-gradient-green text-white">
            <div class="card-body">
                <i class="bi bi-cash-coin display-4 mb-3"></i>
                <h5 class="fw-bold">Rekapan Zakat Fidyah</h5>
                <p>Total Muzakki: <strong>{{ $rekapan['fidyah']['muzakki'] ?? 0 }} Orang</strong></p>
                <p>Total Uang: <strong>Rp {{ number_format($rekapan['fidyah']['uang'] ?? 0, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>

    {{-- Infaq/Shodaqoh --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center bg-gradient-green text-white">
            <div class="card-body">
                <i class="bi bi-heart-fill display-4 mb-3"></i>
                <h5 class="fw-bold">Rekapan Infaq/Shodaqoh</h5>
                <p>Total Donatur: <strong>{{ $rekapan['infaq']['donatur'] ?? 0 }} Orang</strong></p>
                <p>Total Uang: <strong>Rp {{ number_format($rekapan['infaq']['uang'] ?? 0, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>
</div>


      {{-- Informasi --}}
      <div class="mt-5">
          <div class="card shadow-sm border-0 bg-white animate-fade-in">
              <div class="card-body">
                  <h3 class="fw-bold mb-4 text-primary text-center">
                    <i class="bi bi-info-circle-fill me-2"></i>Informasi Lengkap Zakat: Pintu Berkah dan Keberkahan
                  </h3>
                  <p class="text-center elegant-text mb-4">
                      Zakat adalah salah satu dari lima rukun Islam yang wajib dilaksanakan oleh setiap muslim yang mampu. Ia bukan hanya kewajiban, melainkan investasi spiritual yang membawa pahala abadi dan manfaat sosial yang luar biasa. Mari kita eksplorasi dunia zakat dengan lebih mendalam!
                  </p>

                  <!-- Pengantar Zakat -->
                  <div class="row mb-5">
                      <div class="col-md-6">
                          <h5 class="fw-bold text-primary">Apa Itu Zakat?</h5>
                          <p class="elegant-text">
                              Zakat secara harfiah berarti "bersih" atau "tumbuh". Ia adalah kewajiban membagikan sebagian harta kepada yang berhak, sebagai bentuk ibadah dan solidaritas sosial. Zakat membersihkan harta dari hak orang lain dan mendorong pertumbuhan ekonomi yang adil.
                          </p>
                      </div>
                      <div class="col-md-6">
                          <h5 class="fw-bold text-primary">Syarat Wajib Zakat</h5>
                          <ul class="list-unstyled">
                              <li><i class="bi bi-check-circle-fill text-success me-2"></i> Muslim</li>
                              <li><i class="bi bi-check-circle-fill text-success me-2"></i> Baligh (dewasa)</li>
                              <li><i class="bi bi-check-circle-fill text-success me-2"></i> Berakal sehat</li>
                              <li><i class="bi bi-check-circle-fill text-success me-2"></i> Merdeka (bukan budak)</li>
                              <li><i class="bi bi-check-circle-fill text-success me-2"></i> Memiliki harta mencapai nisab</li>
                          </ul>
                      </div>
                  </div>

                  <!-- Carousel untuk Jenis Zakat -->
                  <h5 class="fw-bold text-center mb-4">Jenis-Jenis Zakat</h5>
                  <div id="zakatCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#zakatCarousel" data-bs-slide-to="0" class="active"></button>
                      <button type="button" data-bs-target="#zakatCarousel" data-bs-slide-to="1"></button>
                      <button type="button" data-bs-target="#zakatCarousel" data-bs-slide-to="2"></button>
                    </div>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="info-item text-center">
                          <i class="bi bi-wheat text-success display-1 mb-3"></i>
                          <h4 class="fw-bold text-success">Zakat Fitrah</h4>
                          <p class="lead elegant-text">Wajib bagi setiap muslim menjelang Idul Fitri. Bersihkan jiwa dari dosa-dosa kecil dan sebarkan kebahagiaan.</p>
                          <p><strong>Nisab:</strong> 2,5 kg beras atau setara uang. <strong>Waktu:</strong> Sebelum sholat Idul Fitri.</p>
                          <small class="text-muted">Manfaat: Solidaritas sosial, pembersihan jiwa, pahala berlipat.</small>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <div class="info-item text-center">
                          <i class="bi bi-cash-coin text-warning display-1 mb-3"></i>
                          <h4 class="fw-bold text-warning">Zakat Fidyah</h4>
                          <p class="lead elegant-text">Untuk yang tidak mampu berpuasa Ramadhan. Bayar fidyah sebagai pengganti puasa yang ditinggalkan.</p>
                          <p><strong>Besarnya:</strong> 1 mud (sekitar 0,6 kg) makanan pokok per hari. <strong>Waktu:</strong> Selama Ramadhan.</p>
                          <small class="text-muted">Manfaat: Menebus kewajiban, mendukung kesejahteraan umat.</small>
                        </div>
                      </div>
                      <div class="carousel-item">
                        <div class="info-item text-center">
                          <i class="bi bi-heart-fill text-danger display-1 mb-3"></i>
                          <h4 class="fw-bold text-danger">Infaq/Shodaqoh</h4>
                          <p class="lead elegant-text">Sedekah sukarela yang penuh pahala. Berikan hati Anda untuk membantu sesama tanpa batas.</p>
                          <p><strong>Tidak ada nisab:</strong> Bebas jumlah. <strong>Waktu:</strong> Kapan saja, semakin sering semakin baik.</p>
                          <small class="text-muted">Manfaat: Pahala berlipat, keberkahan dunia-akhirat.</small>
                        </div>
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#zakatCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#zakatCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon"></span>
                    </button>
                  </div>

                  <!-- Timeline Penyaluran -->
                  <h5 class="fw-bold text-center mb-4">Proses Penyaluran Zakat</h5>
                  <div class="timeline">
                      <div class="timeline-item">
                          <h6 class="fw-bold">Pengumpulan</h6>
                          <p>Zakat dikumpulkan dari muzakki melalui panitia resmi atau aplikasi seperti ZakatApp.</p>
                      </div>
                      <div class="timeline-item">
                          <h6 class="fw-bold">Verifikasi</h6>
                          <p>Data mustahik diverifikasi untuk memastikan distribusi tepat sasaran.</p>
                      </div>
                      <div class="timeline-item">
                          <h6 class="fw-bold">Distribusi</h6>
                          <p>Zakat disalurkan kepada 8 golongan mustahik sesuai Al-Quran.</p>
                      </div>
                      <div class="timeline-item">
                          <h6 class="fw-bold">Pelaporan</h6>
                          <p>Laporan transparan diumumkan setiap akhir Ramadhan.</p>
                      </div>
                  </div>

                  <div class="quote mt-4">
                    "Sesungguhnya zakat-zakat itu, hanyalah untuk orang-orang fakir, orang-orang miskin, pengurus-pengurus zakat, para mu'allaf yang dibujuk hatinya, untuk (memerdekakan) budak, orang-orang yang berhutang, untuk jalan Allah dan untuk mereka yang sedang dalam perjalanan, sebagai suatu ketetapan yang diwajibkan Allah." – QS. At-Taubah: 60
                  </div>

                  <div class="fact-box">
                    <h6 class="fw-bold">Fakta Menarik!</h6>
                    <p>Zakat dapat mengurangi kesenjangan sosial hingga 50% jika dikelola dengan baik. Di Indonesia, potensi zakat mencapai Rp 200 triliun per tahun – bayar zakat Anda hari ini dan jadilah agen perubahan!</p>
                  </div>

                  <div class="mt-4 p-4 bg-light rounded">
                      <h6 class="fw-bold text-primary">
                        <i class="bi bi-gear-fill me-2"></i>Penyaluran Zakat di Masjid Kami
                      </h6>
                      <p class="elegant-text">
                          Panitia zakat resmi kami menjalankan penyaluran dengan integritas dan transparansi tinggi. Zakat disalurkan kepada mustahik seperti fakir, miskin, yatim piatu, janda, dan anak-anak terlantar. Kami juga mendukung pembangunan fasilitas sosial dan pendidikan.
                      </p>
                      <p class="elegant-text mb-0">
                        <strong>Tips untuk Anda:</strong> Gunakan ZakatApp untuk bayar zakat online – cepat, aman, dan pahala langsung tercatat. Bergabunglah dalam misi kami untuk membangun masyarakat yang lebih adil dan sejahtera!
                      </p>
                      <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-custom">Mulai Bayar Zakat Sekarang!</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

       {{-- Akses Akun Muzakki --}}
    <div class="access-section text-center">
      <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-shield-lock-fill me-2"></i>Akses Akun Muzakki</h5>
      <p class="text-muted mb-4">Bergabunglah dengan komunitas kami untuk mengelola zakat Anda dengan mudah dan aman.</p>
      <div class="d-flex justify-content-center gap-4 flex-wrap">
        <a href="{{ route('register') }}" class="btn btn-success btn-custom">
          <i class="bi bi-person-plus-fill me-2"></i>Register
        </a>
        <a href="{{ route('login') }}" class="btn btn-primary btn-custom">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
      </div>
      <p class="text-muted mt-3 small">Belum punya akun? Klik <strong>Register</strong> untuk membuat akun baru.</p>
    </div>
  </div>

              {{-- Footer --}}
  <footer class="bg-success text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; {{ date('Y') }} ZakatApp — Transparansi dan Keberkahan Zakat Umat</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>