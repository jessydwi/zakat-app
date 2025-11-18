@extends('layouts.admin')

@section('title', 'Daftar Transaksi Zakat')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-bold text-emerald-800 mb-4">Daftar Transaksi Zakat</h2>

    <div class="mb-4">
        <a href="{{ route('admin.manajemen-zakat.index') }}"
           class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded transition">
            ← Kembali
        </a>
    </div>

    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-emerald-100">
                <th class="px-4 py-2">Nama Muzakki</th>
                <th class="px-4 py-2">Jenis Zakat</th>
                <th class="px-4 py-2">Metode</th>
                <th class="px-4 py-2">Nominal</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
            <tr>
                <td class="px-4 py-2">{{ $t->muzakki->nama ?? '-' }}</td>
                <td class="px-4 py-2">{{ $t->jenisZakat->nama_jenis }}</td>
                <td class="px-4 py-2">{{ $t->metodePembayaran->nama_metode }}</td>
                <td class="px-4 py-2">Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                <td class="px-4 py-2">{{ ucfirst($t->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
