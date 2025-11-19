@extends('layouts.admin')

@section('title', 'Detail Transfer Zakat')

@php
    $idTransaksi   = $idTransaksi ?? '';
    $bankTujuan    = $bankTujuan ?? '';
    $nomorRekening = $nomorRekening ?? '';
    $nominal       = $nominalTransfer ?? '';
    $waktuTransfer = $waktuTransfer ?? \Carbon\Carbon::now()->format('d M Y · H:i:s') . ' WIB';
@endphp

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">
    <h2 class="text-xl font-bold text-emerald-700 flex items-center gap-2">
        <i class="fas fa-check-circle text-emerald-500"></i> Transfer berhasil
    </h2>

    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($nominal, 0, ',', '.') }}</h3>
    <p class="text-sm text-gray-600">{{ $waktuTransfer }}</p>
    <p class="text-sm text-gray-600">Ref ID: {{ $idTransaksi }}</p>

    <div class="mt-4 space-y-2 text-gray-700">
        <p><strong>Penerima:</strong></p>
        <p>{{ $bankTujuan }} · {{ $nomorRekening }}</p>

        <p class="mt-2"><strong>Sumber dana:</strong></p>
        <p>Muzakki (terisi otomatis dari akun)</p>

        <p class="mt-2"><strong>Detail transfer:</strong></p>
        <ul class="list-disc ml-6">
            <li>Nominal: Rp {{ number_format($nominal, 0, ',', '.') }}</li>
            <li>Biaya transaksi: Rp0</li>
            <li>Total: Rp {{ number_format($nominal, 0, ',', '.') }}</li>
        </ul>
    </div>

    <div class="flex gap-3 pt-6">
        <a href="#" onclick="window.print()" class="btn-primary">Unduh / Cetak Bukti</a>
        <a href="{{ route('admin.transaksi.create') }}" class="btn-secondary">Kembali</a>
    </div>
</div>
@endsection
