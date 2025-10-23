<div class="space-y-4">
    <div>
        <label class="block font-semibold mb-1">Tujuan Penggunaan</label>
        <input type="text" name="detail[tujuan]" value="{{ $detail['tujuan'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: Biaya hidup, kebutuhan mendesak">
    </div>

    <div>
        <label class="block font-semibold mb-1">Nominal</label>
        <input type="number" name="detail[nominal]" value="{{ $detail['nominal'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Masukkan jumlah uang">
    </div>
</div>
