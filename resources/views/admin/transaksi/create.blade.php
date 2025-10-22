@extends('layouts.admin')

@section('title', 'Tambah Pembayaran Zakat')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-emerald-800 mb-4">Form Tambah Pembayaran</h2>

    <form method="POST" action="{{ route('admin.transaksi.store') }}">
        @csrf

        <div class="mb-4">
            <label for="muzakki_id" class="block font-medium">Nama Muzakki</label>
            <select name="muzakki_id" id="muzakki_id" class="w-full border rounded px-3 py-2">
                @foreach($muzakki as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="jenis_zakat_id" class="block font-medium">Jenis Zakat</label>
            <select name="jenis_zakat_id" id="jenis_zakat_id" class="w-full border rounded px-3 py-2">
                @foreach($jenisZakat as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="nominal" class="block font-medium">Nominal</label>
            <input type="number" name="nominal" id="nominal" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="metode_id" class="block font-medium">Metode Pembayaran</label>
            <select name="metode_id" id="metode_id" class="w-full border rounded px-3 py-2">
                @foreach($metode as $m)
                    <option value="{{ $m->id }}">{{ $m->nama_metode }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block font-medium">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
            Simpan Pembayaran
        </button>
    </form>
</div>
@endsection
