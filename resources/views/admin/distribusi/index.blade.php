@extends('layouts.admin')

@section('title', 'Detail Distribusi Zakat')

@section('content')
<div class="bg-white rounded-xl shadow-md p-6 space-y-6">

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-blue-800">Detail Distribusi Zakat</h2>
        <a href="{{ route('admin.distribusi.cetak') }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🖨️ Cetak Laporan
        </a>
        <a href="{{ route('admin.dashboard') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    {{-- Filter Bulan & Tahun --}}
    <form method="GET" action="{{ route('admin.distribusi.index') }}" class="flex gap-4 items-center">
        <select name="bulan" class="border rounded px-3 py-2">
            <option value="">-- Semua Bulan --</option>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <select name="tahun" class="border rounded px-3 py-2">
            <option value="">-- Semua Tahun --</option>
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
    </form>

    {{-- Tabel Distribusi --}}
    <div class="overflow-x-auto">
        <table class="table-auto w-full border">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2">Mustahik</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Jenis Bantuan</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distribusi as $d)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $d->mustahik->nama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->mustahik->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->jenisBantuan->nama_bantuan ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Belum ada distribusi zakat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Total Distribusi --}}
    <div class="text-right text-lg font-semibold text-blue-700">
        Total Distribusi: Rp{{ number_format($distribusi->sum('jumlah'), 0, ',', '.') }}
    </div>

    {{-- Pagination (jika pakai paginate) --}}
    <div class="mt-4">
        {{ $distribusi instanceof \Illuminate\Pagination\LengthAwarePaginator ? $distribusi->links() : '' }}
    </div>
</div>
@endsection
