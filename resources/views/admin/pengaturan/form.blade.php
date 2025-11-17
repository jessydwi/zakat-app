{{-- Informasi Lembaga --}}
<div class="bg-white rounded-xl shadow-md p-6 space-y-6 border border-gray-200">
    <h2 class="text-xl font-semibold text-emerald-700 border-b border-emerald-200 pb-2 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Informasi Lembaga
    </h2>
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lembaga</label>
            <input type="text" name="nama_lembaga" value="{{ old('nama_lembaga', $setting->nama_lembaga) }}" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $setting->email) }}" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
            <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="alamat" rows="3" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200" required>{{ old('alamat', $setting->alamat) }}</textarea>
        </div>
    </div>
</div>

{{-- Branding & Notifikasi --}}
<div class="bg-white rounded-xl shadow-md p-6 space-y-6 border border-gray-200">
    <h2 class="text-xl font-semibold text-indigo-700 border-b border-indigo-200 pb-2 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Branding & Notifikasi
    </h2>
    <div class="grid gap-6 md:grid-cols-2 items-center">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Logo Website</label>
            <input type="file" name="logo" class="w-full border border-gray-300 rounded-lg px-4 py-2 cursor-pointer" accept="image/*">
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Lembaga" class="mt-4 h-20 rounded shadow-md object-contain">
            @endif
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Notifikasi Default</label>
            <textarea name="pesan_notifikasi" rows="4" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">{{ old('pesan_notifikasi', $setting->pesan_notifikasi) }}</textarea>
        </div>
    </div>
</div>

{{-- Role Default --}}
<div class="bg-white rounded-xl shadow-md p-6 space-y-4 border border-gray-200">
    <h2 class="text-xl font-semibold text-purple-700 border-b border-purple-200 pb-2 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Manajemen Akses
    </h2>
    <label class="block text-sm font-medium text-gray-700 mb-2">Role Default Pengguna Baru</label>
    <select name="default_role" 
        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
        <option value="admin" @selected($setting->default_role == 'admin')>Admin</option>
        <option value="petugas" @selected($setting->default_role == 'petugas')>Petugas</option>
        <option value="donatur" @selected($setting->default_role == 'donatur')>Donatur</option>
    </select>
</div>