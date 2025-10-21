@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total Zakat Masuk -->
    <div class="bg-blue-100 p-6 rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-blue-800">Zakat Masuk Bulan Ini</h2>
                <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($totalZakat, 0, ',', '.') }}</p>
            </div>
            <div>
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-1.657 0-3 1.343-3 3v5h6v-5c0-1.657-1.343-3-3-3z"/>
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Jumlah Muzakki -->
    <div class="bg-green-100 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-green-800">Jumlah Muzakki</h2>
        <p class="text-2xl font-bold text-green-900">{{ $jumlahMuzakki }}</p>
    </div>

    <!-- Mustahik Terbantu -->
    <div class="bg-yellow-100 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-yellow-800">Mustahik Terbantu</h2>
        <p class="text-2xl font-bold text-yellow-900">{{ $jumlahMustahik }}</p>
    </div>
</div>

<!-- Grafik dan Tabel (opsional) -->
<div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Grafik dummy -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Tren Zakat Masuk (Per Bulan)</h3>
        <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-500">
            [Grafik akan ditampilkan di sini]
        </div>
    </div>

    <!-- Tabel dummy -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Transaksi Zakat Terbaru</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">NIK Muzakki</th>
                    <th class="py-2">Nominal</th>
                    <th class="py-2">Jenis Zakat</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="py-2">1734000000000001</td>
                    <td class="py-2">Rp1.000.000,-</td>
                    <td class="py-2">Zakat Mal</td>
                    <td class="py-2 text-green-600">Selesai</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2">1734000000000002</td>
                    <td class="py-2">Rp500.000,-</td>
                    <td class="py-2">Zakat Fitrah</td>
                    <td class="py-2 text-yellow-600">Pending</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
