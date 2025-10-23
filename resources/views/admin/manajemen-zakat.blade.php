@extends('layouts.admin')

@section('content')
<div class="space-y-10">

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <x-stat-card 
            title="Total Zakat Masuk" 
            :value="$totalZakatMasuk" 
            icon="fas fa-money-bill-wave" 
            color="emerald" 
            subtitle="Zakat yang sudah diterima dan dikonfirmasi"
        />
        <x-stat-card 
            title="Transaksi Belum Terkonfirmasi" 
            :value="$belumTerkonfirmasi" 
            icon="fas fa-hourglass-half" 
            color="yellow" 
            subtitle="Menunggu verifikasi admin"
        />
        <x-stat-card 
            title="Total Distribusi ke Mustahik" 
            :value="$totalDistribusi" 
            icon="fas fa-hand-holding-usd" 
            color="blue" 
            subtitle="Zakat yang telah disalurkan"
        />
    </div>

    {{-- Grafik Zakat Masuk --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <i class="fas fa-chart-line text-emerald-600 text-2xl"></i>
            <h2 class="text-2xl font-bold text-emerald-800">Grafik Zakat Masuk Bulanan</h2>
        </div>
        @livewire('zakat-grafik')
    </div>

    {{-- Daftar Pembayaran Zakat --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-list-ul text-emerald-600 text-2xl"></i>
                <h2 class="text-2xl font-bold text-emerald-800">Daftar Pembayaran Zakat</h2>
            </div>
            <a href="{{ route('admin.transaksi.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                + Tambah Pembayaran
            </a>
        </div>
        @livewire('zakat-table')
    </div>

    {{-- Konfirmasi Pembayaran --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <i class="fas fa-check-circle text-yellow-500 text-2xl"></i>
            <h2 class="text-2xl font-bold text-yellow-700">Konfirmasi Pembayaran</h2>
        </div>
        @livewire('zakat-konfirmasi')
    </div>

    {{-- Distribusi Zakat --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-share text-blue-600 text-2xl"></i>
                <h2 class="text-2xl font-bold text-blue-800">Distribusi Zakat ke Mustahik</h2>
            </div>

            <a href="{{ route('admin.distribusi.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                📋 Lihat Detail Distribusi
            </a>
        </div>

        {{-- Komponen Form Distribusi --}}
        @livewire('zakat-distribusi-form')


    {{-- Cetak Bukti & Laporan --}}
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex items-center gap-3 mb-6">
            <i class="fas fa-print text-gray-600 text-2xl"></i>
            <h2 class="text-2xl font-bold text-gray-800">Cetak Bukti & Laporan</h2>
        </div>
        @livewire('zakat-laporan')
    </div>

    {{-- Modal Detail Mustahik --}}
    <div id="mustahikDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg max-w-lg w-full">
            <h3 class="text-xl font-bold text-blue-800 mb-4">Detail Mustahik</h3>
            <div id="mustahikDetailContent">
                <p>Nama: <span class="font-semibold">Pak Ahmad</span></p>
                <p>Kategori: <span class="font-semibold">Fakir</span></p>
                <p>Alamat: <span class="font-semibold">Jl. Contoh No. 123</span></p>
                <p>Jumlah bantuan terakhir: <span class="font-semibold">Rp500.000</span></p>
            </div>
            <button onclick="closeMustahikDetail()" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Tutup</button>
        </div>
    </div>
</div>
@endsection
