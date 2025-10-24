@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Tambah User</h1>

<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5 max-w-xl" x-data="{ role: '{{ old('role') }}' }">
    @csrf

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
        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2" required>
        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div>
        <label class="block text-sm font-medium mb-1">Peran</label>
        <select name="role" x-model="role" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Peran --</option>
            @foreach(['admin','muzaki','mustahiq'] as $r)
                <option value="{{ $r }}" @selected(old('role') === $r)>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Password --}}
    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Field Tambahan untuk Muzaki --}}
    <template x-if="role === 'muzaki'">
        <div class="mt-6 space-y-4 border-t pt-4">
            <h2 class="text-md font-semibold text-gray-700">Data Muzaki</h2>

            <div>
                <label class="block text-sm font-medium mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded px-3 py-2">
                @error('no_hp') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full border rounded px-3 py-2">
                @error('alamat') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border rounded px-3 py-2">
                @error('pekerjaan') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
    </template>

    {{-- Submit --}}
    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan User
    </button>
</form>
@endsection