@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-emerald-50 to-white flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-3xl bg-white shadow-2xl rounded-3xl p-10 border border-emerald-100">
        {{-- Judul --}}
        <h2 class="text-3xl font-extrabold text-emerald-700 mb-8 text-center tracking-wide">Profil Admin</h2>

        {{-- Info Profil dalam grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Email --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1 tracking-widest">Email</h3>
                <p class="text-lg font-semibold text-gray-800 break-words">{{ $user->email }}</p>
            </div>

            {{-- Nama --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1 tracking-widest">Nama</h3>
                <p class="text-lg font-semibold text-gray-800">{{ $user->nama }}</p>
            </div>

            {{-- Jabatan --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1 tracking-widest">Jabatan</h3>
                <p class="text-lg font-semibold text-gray-800">
                    {{ $user->amil->jabatan ?? '-' }}
                </p>
            </div>

            {{-- Wilayah Tugas --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1 tracking-widest">Wilayah Tugas</h3>
                <p class="text-lg font-semibold text-gray-800">
                    {{ $user->amil->wilayah_tugas ?? '-' }}
                </p>
            </div>

            {{-- Tanggal Dibuat --}}
            <div class="md:col-span-2">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1 tracking-widest">Tanggal Dibuat</h3>
                <p class="text-lg font-semibold text-gray-800">
                    {{ optional($user->amil->created_at)->format('d M Y') ?? '-' }}
                </p>
            </div>
        </div>

        {{-- Tombol Edit Profil (opsional, jika ada route update) --}}
        {{-- 
        <div class="mt-12 flex justify-center">
            <a href="{{ route('admin.profile.edit') }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-10 py-3 rounded-2xl shadow-lg transition transform hover:scale-105 flex items-center gap-3">
               <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div> 
        --}}
    </div>
</div>
@endsection