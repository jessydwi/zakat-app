@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Tambah User</h1>

<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5 max-w-xl">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2" required>
        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Peran</label>
        <select name="role" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Peran --</option>
            @foreach(['admin','muzaki','mustahiq'] as $role)
                <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
        @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan User
    </button>
</form>
@endsection
