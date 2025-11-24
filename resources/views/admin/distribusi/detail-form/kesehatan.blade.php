<div class="space-y-4">
    <div>
        <label class="block font-semibold mb-1">Nama Pasien</label>
        <input type="text" name="detail[nama_pasien]" value="{{ $detail['nama_pasien'] ?? '' }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold mb-1">Jenis Pengobatan</label>
        <input type="text" name="detail[jenis_pengobatan]" value="{{ $detail['jenis_pengobatan'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: Rawat Inap, Operasi">
    </div>

    <div>
        <label class="block font-semibold mb-1">Biaya Pengobatan</label>
        <input type="number" name="detail[biaya]" value="{{ $detail['biaya'] ?? '' }}" class="w-full border rounded px-3 py-2">
    </div>
</div>
