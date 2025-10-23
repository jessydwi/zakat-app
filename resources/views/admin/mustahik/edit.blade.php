@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Edit Mustahik</h1>

<form action="{{ route('admin.mustahik.update', $mustahik) }}" method="POST" class="space-y-4">
    @csrf @method('PUT')

    <div>
        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $mustahik->nama) }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Alamat</label>
        <input type="text" name="alamat" value="{{ old('alamat', $mustahik->alamat) }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Kategori</label>
        <select name="kategori_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList as $k)
                <option value="{{ $k->id }}" @selected(old('kategori_id', $mustahik->kategori_id) == $k->id)>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $mustahik->no_hp) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label>Status Penyaluran</label>
        <select name="status_penyaluran" class="w-full border rounded px-3 py-2">
            <option value="belum" @selected($mustahik->status_penyaluran === 'belum')>Belum</option>
            <option value="disalurkan" @selected($mustahik->status_penyaluran === 'disalurkan')>Disalurkan</option>
            <option value="aktif" @selected($mustahik->status_penyaluran === 'aktif')>Aktif</option>
        </select>

    </div>

    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
        Simpan Perubahan
    </button>
</form>
@endsection
