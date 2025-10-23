@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-xl font-bold">Manajemen Mustahik</h1>
    <a href="{{ route('admin.mustahik.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        + Tambah Mustahik
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="w-full table-auto border rounded shadow-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Alamat</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">No HP</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mustahikList as $m)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $m->nama }}</td>
                    <td class="px-4 py-2">{{ $m->alamat }}</td>
                    <td class="px-4 py-2">{{ $m->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $m->no_hp ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $m->status_penyaluran === 'disalurkan' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($m->status_penyaluran) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.mustahik.edit', $m) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.mustahik.destroy', $m) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data mustahik.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $mustahikList->links() }}
</div>
@endsection
