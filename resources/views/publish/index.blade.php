@extends('layouts.publish.app')

@section('title', 'Halaman Publish Zakat')

@section('content')
  <h2 class="text-center fw-bold mb-4 text-primary">Publish Zakat</h2>

  {{-- REKAPAN ZAKAT FITRAH --}}
  <div class="mt-4">
    <h4 class="section-title">Rekapan Zakat Fitrah</h4>
    <div class="card p-4 mb-4">
      <table class="table table-striped mb-0">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>Nama Muzakki</th>
            <th>Jenis Beras</th>
            <th>Jumlah (Kg)</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>1</td><td>Ahmad</td><td>Premium</td><td>2.5</td><td>10 April 2025</td></tr>
          <tr><td>2</td><td>Budi</td><td>Medium</td><td>2.5</td><td>11 April 2025</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- REKAPAN ZAKAT FIDYAH --}}
  <div class="mt-4">
    <h4 class="section-title">Rekapan Zakat Fidyah</h4>
    <div class="card p-4 mb-4">
      <table class="table table-striped mb-0">
        <thead class="table-success">
          <tr>
            <th>No</th>
            <th>Nama Muzakki</th>
            <th>Jumlah Hari</th>
            <th>Nominal</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>1</td><td>Siti</td><td>5</td><td>Rp 150.000</td><td>12 April 2025</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- REKAPAN INFAQ / SHODAQOH --}}
  <div class="mt-4">
    <h4 class="section-title">Rekapan Infaq / Shodaqoh</h4>
    <div class="card p-4 mb-4">
      <table class="table table-striped mb-0">
        <thead class="table-warning">
          <tr>
            <th>No</th>
            <th>Nama Muzakki</th>
            <th>Jenis Infaq</th>
            <th>Nominal</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>1</td><td>Dewi</td><td>Infaq Masjid</td><td>Rp 200.000</td><td>15 April 2025</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- INFORMASI ZAKAT --}}
  <div class="mt-4">
    <h4 class="section-title">Informasi Zakat</h4>
    <div class="card p-4 mb-4">
      <p><strong>Zakat Fitrah:</strong> Dikeluarkan sebelum sholat Idul Fitri sebesar 2,5 kg beras per jiwa.</p>
      <p><strong>Zakat Fidyah:</strong> Sebagai ganti bagi yang tidak mampu berpuasa, sebesar 1 porsi makan/hari.</p>
      <p><strong>Infaq/Shodaqoh:</strong> Dapat disalurkan kapan saja untuk membantu sesama muslim.</p>
    </div>
  </div>

  {{-- REGISTER --}}
  <div class="mt-5">
    <h4 class="section-title">Register</h4>
    <div class="card p-4 mb-4">
      <form>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Nama</label>
            <input type="text" class="form-control" placeholder="Masukkan nama">
          </div>
          <div class="col-md-6">
            <label>Alamat</label>
            <input type="text" class="form-control" placeholder="Masukkan alamat">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>No Telepon</label>
            <input type="text" class="form-control" placeholder="Masukkan nomor telepon">
          </div>
          <div class="col-md-6">
            <label>Gmail</label>
            <input type="email" class="form-control" placeholder="Masukkan email">
          </div>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Masukkan password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
      </form>
    </div>
  </div>

  {{-- LOGIN --}}
  <div class="mt-4">
    <h4 class="section-title">Login</h4>
    <div class="card p-4 mb-4">
      <form>
        <div class="mb-3">
          <label>Gmail</label>
          <input type="email" class="form-control" placeholder="Masukkan email">
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Masukkan password">
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
      </form>
    </div>
  </div>
@endsection
