@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Manajemen User</h1>

<a href="{{ route('admin.users.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 mb-4 inline-block">+ Tambah User</a>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif

<table class="w-full table-auto border rounded shadow-sm">
    <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Peran</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($userList as $u)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ $u->nama }}</td>
            <td class="px-4 py-2">{{ $u->email }}</td>
            <td class="px-4 py-2 capitalize">{{ $u->role }}</td>
            <td class="px-4 py-2">
                <span class="px-2 py-1 rounded text-xs font-semibold
                    {{ $u->is_active ? 'bg-green-100 text-green-700' : 'bg-green-100 text-green-700' }}">
                    {{ $u->is_active ? 'Aktif' : 'Aktif' }}
                </span>
            </td>
            <td class="px-4 py-2 flex gap-2">
                <a href="{{ route('admin.users.edit', $u) }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $userList->links() }}
</div>
@endsection
