<div class="space-y-4">
    <div>
        <label class="block font-semibold mb-1">Jenis Barang</label>
        <input type="text" name="detail[jenis_barang]" value="{{ $detail['jenis_barang'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: Beras, Minyak, Gula">
    </div>

    <div>
        <label class="block font-semibold mb-1">Jumlah Paket</label>
        <input type="number" name="detail[jumlah_paket]" value="{{ $detail['jumlah_paket'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Masukkan jumlah paket">
    </div>
</div>
