@extends('layouts.admin')

@section('title', 'Distribusi Zakat')

@section('content')
@php
    // Pastikan slug selalu tersedia, baik dari controller atau hasil reload
    $slug = $slug ?? optional(App\Models\JenisBantuan::find(old('jenis_bantuan_id')))->slug;
@endphp

<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-emerald-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header Section --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-600 rounded-full shadow-lg mb-4">
                <i class="fas fa-share text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-emerald-800 mb-2">Form Distribusi Zakat</h1>
            <p class="text-lg text-gray-600">Kelola distribusi zakat dengan mudah dan efisien</p>
        </div>

        {{-- Main Form Card --}}
        <div class="bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition-all duration-500 border border-emerald-100">
            <form method="POST" action="{{ route('admin.distribusi.store') }}" class="space-y-8">
                @csrf

                {{-- Mustahik Section --}}
                <div class="group">
                    <label class="block text-lg font-semibold text-gray-800 mb-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-emerald-600"></i>
                        </div>
                        Pilih Mustahik
                    </label>
                    <select name="mustahik_id" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md text-gray-700">
                        <option value="">-- Pilih Mustahik --</option>
                        @foreach($mustahiks ?? [] as $m)
                            <option value="{{ $m->id }}" {{ old('mustahik_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mustahik_id')
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-2 animate-pulse">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Jenis Bantuan Section --}}
                <div class="group">
                    <label class="block text-lg font-semibold text-gray-800 mb-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hand-holding-heart text-emerald-600"></i>
                        </div>
                        Jenis Bantuan
                    </label>
                    <select name="jenis_bantuan_id" onchange="this.form.submit()" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md text-gray-700">
                        <option value="">-- Pilih Bantuan --</option>
                        @foreach($jenisBantuans ?? [] as $b)
                            <option value="{{ $b->id }}" {{ old('jenis_bantuan_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->nama_bantuan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_bantuan_id')
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-2 animate-pulse">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Jumlah Section --}}
                @unless(in_array($slug, ['uang-tunai', 'beasiswa']))
                    <div class="group">
                        <label class="block text-lg font-semibold text-gray-800 mb-3 flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calculator text-emerald-600"></i>
                            </div>
                            Nominal
                        </label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md text-gray-700" placeholder="Masukkan jumlah bantuan" />
                        @error('jumlah')
                            <span class="text-sm text-red-600 mt-2 flex items-center gap-2 animate-pulse">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                @endunless

                {{-- Tanggal Section --}}
                <div class="group">
                    <label class="block text-lg font-semibold text-gray-800 mb-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-emerald-600"></i>
                        </div>
                        Tanggal Distribusi
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full border-2 border-gray-200 rounded-xl px-5 py-4 focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md text-gray-700" />
                    @error('tanggal')
                        <span class="text-sm text-red-600 mt-2 flex items-center gap-2 animate-pulse">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Form Modular Berdasarkan Jenis Bantuan --}}
                @if($slug)
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 p-6 rounded-2xl border-l-4 border-emerald-500 shadow-inner">
                        <h3 class="text-xl font-bold text-emerald-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i> Detail Bantuan
                        </h3>
                        @includeIf('admin.distribusi.detail-form.' . $slug)
                    </div>
                @endif

                {{-- Submit Button --}}
                <div class="pt-6 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-8 py-4 rounded-2xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-xl flex items-center gap-3 font-semibold text-lg">
                        <i class="fas fa-save"></i>
                        Simpan Distribusi
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection