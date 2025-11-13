@extends('layouts.admin')

@section('title', 'Detail Distribusi Zakat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-8 border border-gray-200">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-xl shadow-lg">
                <h2 class="text-3xl font-bold mb-4 sm:mb-0">Detail Distribusi Zakat</h2>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.distribusi.cetak') }}" target="_blank" class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Laporan
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-gray-50 p-6 rounded-xl shadow-inner">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Distribusi</h3>
                <form method="GET" action="{{ route('admin.distribusi.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                        <select name="bulan" id="bulan" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="">-- Semua Bulan --</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <select name="tahun" id="tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="">-- Semua Tahun --</option>
                            @for($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-md">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                </form>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="table-auto w-full">
                    <thead class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Mustahik</th>
                            <th class="px-6 py-4 text-left font-semibold">Kategori</th>
                            <th class="px-6 py-4 text-left font-semibold">Jenis Bantuan</th>
                            <th class="px-6 py-4 text-left font-semibold">Jumlah</th>
                            <th class="px-6 py-4 text-left font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($distribusi as $d)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 text-gray-900">{{ $d->mustahik->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $d->mustahik->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $d->jenisBantuan->nama_bantuan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-900 font-medium">Rp{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-.88-5.812-2.29M12 2a10 10 0 100 20 10 10 0 000-20z"></path>
                                </svg>
                                Belum ada distribusi zakat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Section -->
            <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white p-6 rounded-xl shadow-lg text-center">
                <h3 class="text-xl font-bold mb-2">Total Distribusi</h3>
                <p class="text-2xl font-extrabold">Rp{{ number_format($distribusi->sum('jumlah'), 0, ',', '.') }}</p>
            </div>

            <!-- Pagination Section -->
            @if($distribusi instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-8 flex justify-center">
                {{ $distribusi->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection