<div class="space-y-4">
    <div>
        <label class="block font-semibold mb-1">Nama Siswa</label>
        <input type="text" name="detail[nama_siswa]" value="{{ $detail['nama_siswa'] ?? '' }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold mb-1">Jenjang Pendidikan</label>
        <input type="text" name="detail[jenjang]" value="{{ $detail['jenjang'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: SD, SMP, SMA">
    </div>

    <div>
        <label class="block font-semibold mb-1">Biaya Pendidikan</label>
        <input type="number" name="detail[nominal]" value="{{ $detail['nominal'] ?? '' }}" class="w-full border rounded px-3 py-2">
    </div>
</div>
