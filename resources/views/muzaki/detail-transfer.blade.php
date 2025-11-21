@extends('layouts.muzaki')

@section('title', 'Detail Transfer Zakat')

@php
    $idTransaksi     = session('idTransaksi') ?? '-';
    $bankTujuan      = session('bankTujuan') ?? '-';
    $nomorRekening   = session('nomorRekening') ?? '-';
    $nominalTransfer = session('nominalTransfer');
    $nominal         = is_numeric($nominalTransfer) ? (float) $nominalTransfer : 0;
    $waktuTransfer   = session('waktuTransfer') ?? now()->format('d M Y · H:i:s') . ' WIB';
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-green-100 py-12 px-4">
    <div class="container mx-auto max-w-3xl">
        <div id="printArea" class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-8 text-center relative">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="relative z-10">
                    <div class="flex justify-center mb-4">
                        <div class="bg-white bg-opacity-20 rounded-full p-4">
                            <i class="fas fa-check-circle text-white text-5xl"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold mb-2">Transfer Berhasil</h2>
                    <h3 class="text-4xl font-extrabold mb-4">
                        Rp {{ number_format($nominal, 0, ',', '.') }}
                    </h3>
                    <p class="text-emerald-100 text-sm mb-1">{{ $waktuTransfer }}</p>
                    <p class="text-emerald-100 text-sm">Ref ID: <span class="font-mono bg-white bg-opacity-20 px-2 py-1 rounded">{{ $idTransaksi }}</span></p>
                </div>
            </div>

            <!-- Details Section -->
            <div class="p-8 space-y-6">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-user text-emerald-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-800">Penerima</h4>
                    </div>
                    <p class="text-gray-600 ml-6">{{ $bankTujuan }} · {{ $nomorRekening }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-wallet text-emerald-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-800">Sumber Dana</h4>
                    </div>
                    <p class="text-gray-600 ml-6">
                        {{ auth()->user()->nama ?? 'Muzakki (terisi otomatis dari akun)' }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-list-alt text-emerald-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-800">Detail Transfer</h4>
                    </div>
                    <ul class="space-y-3 ml-6">
                        <li class="flex justify-between">
                            <span class="text-gray-600">Nominal:</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($nominal, 0, ',', '.') }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-600">Biaya Transaksi:</span>
                            <span class="font-semibold text-gray-800">Rp 0</span>
                        </li>
                        <li class="flex justify-between border-t border-gray-300 pt-3">
                            <span class="text-gray-800 font-semibold">Total:</span>
                            <span class="font-bold text-emerald-600 text-lg">Rp {{ number_format($nominal, 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 no-print">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="window.print()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-download mr-2"></i> Unduh / Cetak Bukti
                    </button>
                    <a href="{{ route('muzaki.bayar') }}" class="flex-1 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-4 px-6 rounded-xl border border-gray-300 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection
