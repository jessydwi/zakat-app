@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Tambah Mustahik</h1>

<form action="{{ route('admin.mustahik.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Nama</label>
        <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Alamat</label>
        <input type="text" name="alamat" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Kategori</label>
        <select name="kategori_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>No HP</label>
        <input type="text" name="no_hp" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label>Status Penyaluran</label>
        <select name="status_penyaluran" class="w-full border rounded px-3 py-2">
            <option value="belum">Belum</option>
            <option value="disalurkan">Disalurkan</option>
            <option value="aktif">Aktif</option>

        </select>
    </div>

    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan
    </button>
</form>
@endsection
