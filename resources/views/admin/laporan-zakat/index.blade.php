@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Laporan & Rekapitulasi Zakat</h1>

<form method="GET" class="flex gap-4 items-center mb-6">
    <div>
        <label>Dari</label>
        <input type="date" name="start" value="{{ $start }}" class="border rounded px-3 py-2">
    </div>
    <div>
        <label>Sampai</label>
        <input type="date" name="end" value="{{ $end }}" class="border rounded px-3 py-2">
    </div>
    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">Filter</button>
</form>

<div class="grid grid-cols-2 gap-6 mb-6">
    <div class="bg-white border rounded p-4 shadow">
        <h2 class="text-sm font-semibold text-gray-500 mb-2">Total Zakat Masuk</h2>
        <div class="text-2xl font-bold text-emerald-700">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white border rounded p-4 shadow">
        <h2 class="text-sm font-semibold text-gray-500 mb-2">Total Zakat Disalurkan</h2>
        <div class="text-2xl font-bold text-red-600">Rp {{ number_format($totalDistribusi, 0, ',', '.') }}</div>
    </div>
</div>

<h2 class="text-lg font-semibold mb-4">Rekap Distribusi</h2>

<table class="w-full table-auto border rounded shadow-sm">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Mustahik</th>
            <th class="px-4 py-2">Jenis Bantuan</th>
            <th class="px-4 py-2">Jumlah</th>
            <th class="px-4 py-2">Detail</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rekapDistribusi as $d)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-2">{{ $d->mustahik->nama ?? '-' }}</td>
            <td class="px-4 py-2">{{ $d->jenisBantuan->nama_bantuan ?? '-' }}</td>
            <td class="px-4 py-2">{{ $d->jumlah }}</td>
            <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit(json_encode($d->detail_json), 50) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada distribusi pada rentang waktu ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
