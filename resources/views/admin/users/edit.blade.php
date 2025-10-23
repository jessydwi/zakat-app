@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-6">Edit User</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5 max-w-xl">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full border rounded px-3 py-2" required>
        @error('nama') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2" required>
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Peran</label>
        <select name="role" class="w-full border rounded px-3 py-2" required>
            @foreach(['admin','muzaki','mustahiq'] as $role)
                <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ ucfirst($role) }}</option>
            @endforeach
        </select>
        @error('role') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded">
        <label class="text-sm">Aktif</label>
    </div>

    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan Perubahan
    </button>
</form>
@endsection
