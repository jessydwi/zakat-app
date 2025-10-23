@extends('layouts.admin')

@section('title', 'Detail Distribusi Zakat')

@section('content')
@php
    $detail = is_array($distribusi->detail_json) ? $distribusi->detail_json : json_decode($distribusi->detail_json, true);
    $slug = $distribusi->jenisBantuan->slug ?? null;
@endphp

<div class="bg-white rounded-xl shadow p-6 space-y-4">
    <h2 class="text-xl font-bold text-blue-800 mb-4">Detail Distribusi Zakat</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><strong>Mustahik:</strong> {{ $distribusi->mustahik->nama }}</div>
        <div><strong>Kategori:</strong> {{ $distribusi->mustahik->kategori->nama_kategori ?? '-' }}</div>
        <div><strong>Jenis Bantuan:</strong> {{ $distribusi->jenisBantuan->nama_bantuan }}</div>
        <div><strong>Slug:</strong> {{ $slug }}</div>
        <div><strong>Jumlah:</strong> Rp{{ number_format($distribusi->jumlah) }}</div>
        <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($distribusi->tanggal)->format('d/m/Y') }}</div>
        <div><strong>Status:</strong> {{ ucfirst($distribusi->status) }}</div>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold text-blue-700 mb-2">Detail Bantuan</h3>
        <div class="bg-gray-50 p-4 rounded text-sm">
            @switch($slug)
                @case('sembako')
                    <p>Paket: {{ $detail['jumlah_paket'] ?? '-' }}</p>
                    <p>Barang: {{ $detail['jenis_barang'] ?? '-' }}</p>
                    @break

                @case('beasiswa')
                    <p>Nama Siswa: {{ $detail['nama_siswa'] ?? '-' }}</p>
                    <p>Jenjang: {{ $detail['jenjang'] ?? '-' }}</p>
                    <p>Nominal: Rp{{ number_format($detail['nominal'] ?? 0) }}</p>
                    @break

                @case('modal-usaha')
                    <p>Jenis Usaha: {{ $detail['jenis_usaha'] ?? '-' }}</p>
                    <p>Modal: Rp{{ number_format($detail['modal'] ?? 0) }}</p>
                    <p>Pendampingan: {{ $detail['pendampingan'] ?? '-' }}</p>
                    @break

                @case('kesehatan')
                    <p>Nama Pasien: {{ $detail['nama_pasien'] ?? '-' }}</p>
                    <p>Jenis Pengobatan: {{ $detail['jenis_pengobatan'] ?? '-' }}</p>
                    <p>Biaya: Rp{{ number_format($detail['biaya'] ?? 0) }}</p>
                    @break

                @case('uang-tunai')
                    <p>Nama Penerima: {{ $detail['nama_penerima'] ?? '-' }}</p>
                    <p>Nominal: Rp{{ number_format($detail['nominal'] ?? 0) }}</p>
                    <p>Tujuan: {{ $detail['tujuan'] ?? '-' }}</p>
                    @break

                @default
                    <p>-</p>
            @endswitch
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.distribusi.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ← Kembali ke Daftar Distribusi
        </a>
    </div>
</div>
@endsection
