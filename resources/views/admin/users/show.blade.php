@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Detail User</h1>
                        <p class="text-emerald-100 mt-2">Informasi lengkap pengguna sistem</p>
                    </div>
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-white text-emerald-600 font-semibold rounded-lg shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Detail Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Basic Information -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Dasar
            </h2>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-16 w-16">
                    <div class="h-16 w-16 rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 flex items-center justify-center">
                        <span class="text-xl font-medium text-white">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-600">Email</span>
                    <span class="text-sm text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-600">Peran</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $user->role }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-600">Status</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Dibuat Pada</span>
                    <span class="text-sm text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($user->role === 'muzaki' && $muzaki)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Data Muzaki
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Nomor HP</span>
                        <span class="text-sm text-gray-900">{{ $muzaki->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Alamat</span>
                        <span class="text-sm text-gray-900">{{ $muzaki->alamat ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600">Pekerjaan</span>
                        <span class="text-sm text-gray-900">{{ $muzaki->pekerjaan ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @elseif($user->role === 'admin' && $amil)
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Data Amil
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Jabatan</span>
                        <span class="text-sm text-gray-900">{{ $amil->jabatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600">Wilayah Tugas</span>
                        <span class="text-sm text-gray-900">{{ $amil->wilayah_tugas ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Tambahan
                </h2>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-center">Tidak ada informasi tambahan untuk peran ini.</p>
            </div>
        </div>
    @endif
</div>


        <!-- Activity Summary (Optional) -->
        <div class="mt-8 bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Ringkasan Aktivitas
                </h2>
            </div>
            <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-600">
                        {{ number_format($totalZakatMasuk ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-600">Total Zakat Masuk</div>
                </div>

                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ number_format($totalDistribusi ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-600">Total Distribusi</div>
                </div>

                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $user->created_at ? $user->created_at->diffInDays(now()) : 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Hari Sejak Bergabung</div>
                </div>
                </div>
        </div>
    </div>
</div>
@endsection