@extends('layouts.muzaki')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Detail Bukti Pembayaran Zakat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-emerald-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Detail Bukti Pembayaran</h1>
                    <p class="text-emerald-100 mt-2">Informasi lengkap tentang pembayaran zakat Anda</p>
                </div>
                <a href="{{ route('muzaki.riwayat') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-emerald-600 font-semibold rounded-lg shadow-md hover:bg-gray-100">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600">
                <h2 class="text-xl font-bold text-white">Informasi Zakat</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data Muzakki -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Muzakki</h3>
                        <div class="space-y-3">
                            <p>Nama Muzakki: {{ $transaksi->muzakki->nama ?? $transaksi->nama }}</p>
                            <p>Jenis Kelamin: {{ $transaksi->detail['jenis_kelamin'] ?? '-' }}</p>
                            <p>Kontak: {{ $transaksi->kontak ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Detail Zakat -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Zakat</h3>
                        <div class="space-y-3">
                            <p>Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</p>
                            <p>Jenis Zakat: {{ $transaksi->jenisZakat->nama_jenis ?? '-' }}</p>
                            <p>Metode Pembayaran: {{ $transaksi->metodePembayaran->nama_metode ?? '-' }}</p>
                            <p>Jumlah: Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</p>
                            <p>Status: 
                                @if($transaksi->status === 'terbayar')
                                    <span class="px-3 py-1 text-sm font-semibold text-emerald-800 bg-emerald-100 rounded-full">✔️ Terbayar</span>
                                @elseif($transaksi->status === 'menunggu')
                                    <span class="px-3 py-1 text-sm font-semibold text-amber-800 bg-amber-100 rounded-full">⏳ Menunggu</span>
                                @else
                                    <span class="px-3 py-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full">❔ {{ ucfirst($transaksi->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Detail Tambahan -->
                @if($transaksi->detail)
                    @php
                        $detail = is_array($transaksi->detail) ? $transaksi->detail : json_decode($transaksi->detail, true);
                    @endphp
                    @if(is_array($detail))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tambahan</h3>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                @foreach($detail as $key => $value)
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">{{ Str::headline($key) }}</span>
                                        <span class="text-gray-900">{{ is_numeric($value) ? 'Rp ' . number_format($value, 0, ',', '.') : $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Bukti Pembayaran -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Pembayaran</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @php
                            $ext = pathinfo($bukti->file_path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                            <img src="{{ $bukti->file_url }}" alt="Bukti Pembayaran" class="rounded-lg shadow-md max-h-64">
                        @else
                            <a href="{{ route('muzaki.bukti', $bukti->id) }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700">
                                Lihat Bukti
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
