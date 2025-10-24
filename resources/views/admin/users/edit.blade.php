@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Edit User</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5 max-w-xl" x-data="{ role: '{{ old('role', $user->role) }}' }">
    @csrf @method('PUT')

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full border rounded px-3 py-2" required>
        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2" required>
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div>
        <label class="block text-sm font-medium mb-1">Peran</label>
        <select name="role" x-model="role" class="w-full border rounded px-3 py-2" required>
            @foreach(['admin','muzaki','mustahiq'] as $r)
                <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Status Aktif --}}
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded">
        <label class="text-sm">Aktif</label>
    </div>

    {{-- Field Tambahan untuk Muzaki --}}
    <template x-if="role === 'muzaki'">
        <div class="mt-6 space-y-4 border-t pt-4">
            <h2 class="text-md font-semibold text-gray-700">Data Muzaki</h2>

            <div>
                <label class="block text-sm font-medium mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $muzaki->no_hp ?? '') }}" class="w-full border rounded px-3 py-2">
                @error('no_hp') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $muzaki->alamat ?? '') }}" class="w-full border rounded px-3 py-2">
                @error('alamat') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $muzaki->pekerjaan ?? '') }}" class="w-full border rounded px-3 py-2">
                @error('pekerjaan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    </template>

    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan Perubahan
    </button>
</form>
@endsection
