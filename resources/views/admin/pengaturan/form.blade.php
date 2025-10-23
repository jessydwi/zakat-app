{{-- Informasi Lembaga --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Lembaga</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-600">Nama Lembaga</label>
            <input type="text" name="nama_lembaga" value="{{ old('nama_lembaga', $setting->nama_lembaga) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-600">No. HP</label>
            <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-600">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500" required>{{ old('alamat', $setting->alamat) }}</textarea>
        </div>
    </div>
</div>

{{-- Branding & Notifikasi --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Branding & Notifikasi</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-600">Logo Website</label>
            <input type="file" name="logo" class="w-full border rounded-lg px-4 py-2" accept="image/*">
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" class="h-16 mt-2 rounded shadow" alt="Logo Lembaga">
            @endif
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-600">Pesan Notifikasi Default</label>
            <textarea name="pesan_notifikasi" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500">{{ old('pesan_notifikasi', $setting->pesan_notifikasi) }}</textarea>
        </div>
    </div>
</div>

{{-- Role Default --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Manajemen Akses</h2>
    <label class="block text-sm font-medium text-gray-600 mb-1">Role Default Pengguna Baru</label>
    <select name="default_role" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500">
        <option value="admin" @selected($setting->default_role == 'admin')>Admin</option>
        <option value="petugas" @selected($setting->default_role == 'petugas')>Petugas</option>
        <option value="donatur" @selected($setting->default_role == 'donatur')>Donatur</option>
    </select>
</div>
