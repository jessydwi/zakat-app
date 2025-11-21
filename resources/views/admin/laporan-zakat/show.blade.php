@extends('layouts.admin')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Detail Zakat Masuk</h1>
                        <p class="text-blue-100 mt-2">Informasi lengkap tentang zakat yang diterima</p>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:bg-gray-100">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600">
                <h2 class="text-xl font-bold text-white">Informasi Zakat</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data Muzakki -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Muzakki</h3>
                        <div class="space-y-3">
                            <p>Nama Muzakki: {{ $transaksi->muzakki?->nama ?? $transaksi->nama_muzakki ?? '-' }}</p>
                            <p>Nama: {{ $transaksi->nama ?? '-' }}</p>
                            <p>Jenis Kelamin: {{ $transaksi->jenis_kelamin ?? '-' }}</p>
                            <p>Kontak: {{ $transaksi->kontak ?? '-' }}</p>
                        </div>
                    </div>
                    <!-- Detail Zakat -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Zakat</h3>
                        <div class="space-y-3">
                            <p>Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</p>
                            <p>Jenis Zakat: {{ $transaksi->jenisZakat->nama_jenis ?? $transaksi->jenis_zakat }}</p>
                            <p>Metode Pembayaran: {{ $transaksi->metodePembayaran->nama_metode ?? ucfirst($transaksi->metode_pembayaran ?? '-') }}</p>
                            <p>Jumlah: Rp {{ number_format($transaksi->nominal ?? $transaksi->jumlah, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <!-- Informasi Amil -->
                    @if($transaksi->amil && $transaksi->amil->user)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Petugas Konfirmasi (Amil)</h3>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Nama Amil</span>
                                    <span class="text-gray-900">{{ $transaksi->amil->user->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Jabatan</span>
                                    <span class="text-gray-900">{{ $transaksi->amil->jabatan ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-700">Wilayah Tugas</span>
                                    <span class="text-gray-900">{{ $transaksi->amil->wilayah_tugas ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Detail Tambahan -->
                @if($transaksi->detail)
                    @php
                        $detail = is_array($transaksi->detail)
                            ? $transaksi->detail
                            : json_decode($transaksi->detail, true);
                    @endphp

                    @if(is_array($detail))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tambahan</h3>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                               @foreach($detail as $key => $value)
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">{{ Str::headline($key) }}</span>
                                        <span class="text-gray-900">
                                            @if(in_array($key, ['nominal', 'nominal_fidyah']))
                                                Rp {{ number_format($value, 0, ',', '.') }}
                                            @elseif($key === 'jumlah_hari')
                                                {{ $value }} hari
                                            @else
                                                {{ $value }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tambahan</h3>
                            <div class="bg-red-50 p-4 rounded-lg text-red-700">
                                Format JSON tidak valid.
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Bukti Pembayaran -->
                @if($transaksi->buktiPembayaran)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Pembayaran</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @php
                                $ext = pathinfo($transaksi->buktiPembayaran->file_path, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                <img src="{{ $transaksi->buktiPembayaran->file_url }}" 
                                     alt="Bukti Pembayaran" 
                                     class="rounded-lg shadow-md max-h-64">
                            @else
                                <a href="{{ $transaksi->buktiPembayaran->file_url }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">
                                    Lihat Bukti
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.laporan-zakat.edit', $transaksi->id) }}" 
               class="px-6 py-3 bg-yellow-500 text-white rounded-lg">Edit</a>
            <form action="{{ route('admin.laporan-zakat.destroy', $transaksi->id) }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data zakat ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection
