<form method="POST" action="{{ route('admin.distribusi.store') }}">
    @csrf

    <div>
        <label>Mustahik</label>
        <select name="mustahik_id">
            <option value="">-- Pilih Mustahik --</option>
            @foreach($mustahiks as $m)
                <option value="{{ $m->id }}" {{ old('mustahik_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Jenis Bantuan</label>
        <select name="jenis_bantuan_id" onchange="this.form.submit()">
            <option value="">-- Pilih Bantuan --</option>
            @foreach($jenisBantuans as $b)
                <option value="{{ $b->id }}" {{ old('jenis_bantuan_id') == $b->id ? 'selected' : '' }}>
                    {{ $b->nama_bantuan }}
                </option>
            @endforeach
        </select>
    </div>

    @php
        $slug = optional(App\Models\JenisBantuan::find(old('jenis_bantuan_id')))->slug;
    @endphp

    @includeIf('admin.detail-form.' . $slug)

    <div>
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}">
    </div>

    <button type="submit">Simpan Distribusi</button>
</form>
