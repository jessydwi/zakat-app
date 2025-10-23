@extends('layouts.admin')

@section('title', 'Pengaturan Umum Website')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6 space-y-6">
    <h1 class="text-2xl font-bold text-blue-800">Pengaturan Umum Website Zakat</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Informasi Lembaga --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Nama Lembaga</label>
                <input type="text" name="nama_lembaga" value="{{ old('nama_lembaga', $setting->nama_lembaga) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border rounded px-3 py-2">{{ old('alamat', $setting->alamat) }}</textarea>
            </div>
        </div>

        {{-- Branding & Notifikasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Logo Website</label>
                <input type="file" name="logo" class="w-full border rounded px-3 py-2">
                @if($setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" class="h-16 mt-2">
                @endif
            </div>
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Pesan Notifikasi Default</label>
                <textarea name="pesan_notifikasi" class="w-full border rounded px-3 py-2">{{ old('pesan_notifikasi', $setting->pesan_notifikasi) }}</textarea>
            </div>
        </div>

        {{-- Role Default --}}
        <div>
            <label class="block font-semibold mb-1">Role Default Pengguna Baru</label>
            <select name="default_role" class="w-full border rounded px-3 py-2">
                <option value="admin" @selected($setting->default_role == 'admin')>Admin</option>
                <option value="petugas" @selected($setting->default_role == 'petugas')>Petugas</option>
                <option value="donatur" @selected($setting->default_role == 'donatur')>Donatur</option>
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
