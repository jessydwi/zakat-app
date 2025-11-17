@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Edit Distribusi Zakat</h1>

    <form action="{{ route('admin.laporan-zakat.update-distribusi', $distribusi->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Mustahik -->
        <div>
            <label for="mustahik_id">Mustahik</label>
            <select id="mustahik_id" name="mustahik_id" required>
                <option value="">Pilih Mustahik</option>
                @foreach($mustahik as $m)
                    <option value="{{ $m->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $m->id ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jenis Bantuan -->
        <div>
            <label for="jenis_bantuan_id">Jenis Bantuan</label>
            <select id="jenis_bantuan_id" name="jenis_bantuan_id" required>
                <option value="">Pilih Jenis Bantuan</option>
                @foreach($jenisBantuan as $jb)
                    <option value="{{ $jb->id }}" {{ old('jenis_bantuan_id', $distribusi->jenis_bantuan_id) == $jb->id ? 'selected' : '' }}>
                        {{ $jb->nama_bantuan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jumlah -->
        <div>
            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $distribusi->jumlah) }}" required min="0" step="0.01">
        </div>

        <!-- Detail JSON -->
        <div>
            <label for="detail_json">Detail Tambahan (JSON)</label>
            <textarea id="detail_json" name="detail_json" rows="4">{{ old('detail_json', json_encode($distribusi->detail_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
@endsection
