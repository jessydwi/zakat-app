<div class="space-y-4">
    <div>
        <label>Jenis Usaha</label>
        <input type="text" name="detail[jenis_usaha]" value="{{ $detail['jenis_usaha'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: Warung, Jahit, dll">
    </div>
    <div>
        <label>Modal Diberikan</label>
        <input type="number" name="detail[modal]" value="{{ $detail['modal'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Masukkan nominal modal">
    </div>
    <div>
        <label>Pendampingan</label>
        <input type="text" name="detail[pendampingan]" value="{{ $detail['pendampingan'] ?? '' }}" class="w-full border rounded px-3 py-2" placeholder="Contoh: Pelatihan, Mentoring">
    </div>
</div>
