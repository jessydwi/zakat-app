@extends('layouts.admin')

@section('title', 'Distribusi Zakat')

@section('content')
@php
    // Pastikan slug selalu tersedia, baik dari controller atau hasil reload
    $slug = $slug ?? optional(App\Models\JenisBantuan::find(old('jenis_bantuan_id')))->slug;
@endphp

<form method="POST" action="{{ route('admin.distribusi.store') }}" class="space-y-6">
    @csrf

    {{-- Mustahik --}}
    <div>
        <label class="block font-semibold mb-1">Mustahik</label>
        <select name="mustahik_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Mustahik --</option>
            @foreach($mustahiks ?? [] as $m)
                <option value="{{ $m->id }}" {{ old('mustahik_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
            @endforeach
        </select>
        @error('mustahik_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Jenis Bantuan --}}
    <div>
        <label class="block font-semibold mb-1">Jenis Bantuan</label>
        <select name="jenis_bantuan_id" onchange="this.form.submit()" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Bantuan --</option>
            @foreach($jenisBantuans ?? [] as $b)
                <option value="{{ $b->id }}" {{ old('jenis_bantuan_id') == $b->id ? 'selected' : '' }}>
                    {{ $b->nama_bantuan }}
                </option>
            @endforeach
        </select>
        @error('jenis_bantuan_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Jumlah --}}
    @unless(in_array($slug, ['uang-tunai', 'beasiswa']))
        <div>
            <label class="block font-semibold mb-1">Jumlah</label>
            <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="w-full border rounded px-3 py-2">
            @error('jumlah') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    @endunless

    {{-- Tanggal --}}
    <div>
        <label class="block font-semibold mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full border rounded px-3 py-2">
        @error('tanggal') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Form Modular Berdasarkan Jenis Bantuan --}}
    @includeIf('admin.distribusi.detail-form.' . $slug)

    {{-- Tombol Submit --}}
    <div>
        <button type="submit" class="bg-emerald-600 text-white px-5 py-2 rounded hover:bg-emerald-700 transition">
            💾 Simpan Distribusi
        </button>
    </div>
</form>
@endsection
