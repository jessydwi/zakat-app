@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Detail Distribusi Zakat</h1>
                        <p class="text-purple-100 mt-2">Informasi lengkap tentang distribusi zakat kepada mustahik</p>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-purple-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-600">
                <h2 class="text-xl font-bold text-white">Informasi Distribusi</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Mustahik</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Mustahik</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $distribusi->mustahik->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Distribusi</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Bantuan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $distribusi->jenisBantuan->nama_bantuan ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($distribusi->tanggal)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <p class="mt-1 text-2xl font-bold text-red-600">Rp {{ number_format($distribusi->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if($distribusi->detail_json)
                    @php
                        $detail = is_array($distribusi->detail_json) ? $distribusi->detail_json : json_decode($distribusi->detail_json, true);
                    @endphp
                    @if(is_array($detail))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Tambahan</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-2">
                                    @foreach($detail as $key => $value)
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-700">{{ \Illuminate\Support\Str::headline($key) }}</span>
                                            <span class="text-gray-900">{{ is_numeric($value) ? 'Rp ' . number_format($value, 0, ',', '.') : $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.distribusi.edit', $distribusi->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.distribusi.destroy', $distribusi->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data distribusi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-lg shadow-md hover:from-red-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection