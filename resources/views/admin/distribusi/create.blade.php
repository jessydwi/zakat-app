@extends('layouts.admin')

@section('title', 'Distribusi Zakat')

@section('content')
@php
    // Pastikan slug selalu tersedia, baik dari controller atau hasil reload
    $slug = $slug ?? optional(App\Models\JenisBantuan::find(old('jenis_bantuan_id')))->slug;
@endphp

<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    {{-- Header Form --}}
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-share text-emerald-600 text-2xl"></i>
        <h2 class="text-xl font-bold text-emerald-800">Form Distribusi Zakat</h2>
    </div>

    <form method="POST" action="{{ route('admin.distribusi.store') }}" class="space-y-6">
        @csrf

        {{-- Mustahik --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-user text-emerald-600"></i> Mustahik
            </label>
            <select name="mustahik_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm">
                <option value="">-- Pilih Mustahik --</option>
                @foreach($mustahiks ?? [] as $m)
                    <option value="{{ $m->id }}" {{ old('mustahik_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                @endforeach
            </select>
            @error('mustahik_id') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Jenis Bantuan --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-emerald-600"></i> Jenis Bantuan
            </label>
            <select name="jenis_bantuan_id" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm">
                <option value="">-- Pilih Bantuan --</option>
                @foreach($jenisBantuans ?? [] as $b)
                    <option value="{{ $b->id }}" {{ old('jenis_bantuan_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_bantuan }}
                    </option>
                @endforeach
            </select>
            @error('jenis_bantuan_id') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Jumlah --}}
        @unless(in_array($slug, ['uang-tunai', 'beasiswa']))
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-calculator text-emerald-600"></i> Jumlah
                </label>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm" placeholder="Masukkan jumlah" />
                @error('jumlah') 
                    <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                    </span> 
                @enderror
            </div>
        @endunless

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-emerald-600"></i> Tanggal
            </label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm" />
            @error('tanggal') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Form Modular Berdasarkan Jenis Bantuan --}}
        @if($slug)
            <div class="bg-emerald-50 p-4 rounded-lg border-l-4 border-emerald-500">
                @includeIf('admin.distribusi.detail-form.' . $slug)
            </div>
        @endif

        {{-- Tombol Submit --}}
        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i> 💾 Simpan Distribusi
            </button>
        </div>
    </form>
</div>


@endsection