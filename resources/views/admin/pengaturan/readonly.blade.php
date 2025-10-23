{{-- Branding Header --}}
<div class="flex items-center gap-4 mb-6">
    @if($setting->logo)
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Lembaga" class="h-16 w-16 rounded-full shadow-md object-cover">
    @else
        <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">
            ?
        </div>
    @endif
    <div>
        <h2 class="text-xl font-bold text-emerald-700 font-serif">{{ $setting->nama_lembaga ?? 'Nama Lembaga' }}</h2>
        <p class="text-sm text-gray-500">Platform Zakat yang Amanah, Profesional, dan Terpercaya</p>
    </div>
</div>

{{-- Informasi Lembaga --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Lembaga</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-600">Email</label>
            <p class="text-gray-800">{{ $setting->email ?? '-' }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-600">No. HP</label>
            <p class="text-gray-800">{{ $setting->telepon ?? '-' }}</p>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-600">Alamat</label>
            <p class="text-gray-800">{{ $setting->alamat ?? '-' }}</p>
        </div>
    </div>
</div>

{{-- Branding & Notifikasi --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Branding & Notifikasi</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-600">Logo Website</label>
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" class="h-16 mt-2 rounded shadow" alt="Logo Lembaga">
            @else
                <p class="text-gray-800">Belum diatur</p>
            @endif
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-600">Pesan Notifikasi Default</label>
            <p class="text-gray-800">{{ $setting->pesan_notifikasi ?? 'Belum diatur' }}</p>
        </div>
    </div>
</div>

{{-- Ketentuan Zakat --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Ketentuan Zakat</h2>
    @if($data->isEmpty())
        <p class="text-gray-500">Belum ada ketentuan zakat yang ditambahkan.</p>
    @else
        @foreach($data as $jenis => $items)
            <div class="mt-4">
                <h3 class="text-md font-semibold text-blue-700 mb-1">{{ ucfirst($jenis) }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">Parameter</th>
                                <th class="px-3 py-2 text-left">Nilai</th>
                                <th class="px-3 py-2 text-left">Satuan</th>
                                <th class="px-3 py-2 text-left">Uang</th>
                                <th class="px-3 py-2 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $item->parameter }}</td>
                                <td class="px-3 py-2">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                                <td class="px-3 py-2">{{ $item->satuan }}</td>
                                <td class="px-3 py-2">
                                    {{ $item->nilai_uang ? 'Rp ' . number_format($item->nilai_uang, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-3 py-2">{{ $item->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>

{{-- Role Default --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Manajemen Akses</h2>
    <label class="block text-sm font-medium text-gray-600 mb-1">Role Default Pengguna Baru</label>
    <p class="text-gray-800">{{ ucfirst($setting->default_role ?? 'donatur') }}</p>
</div>
