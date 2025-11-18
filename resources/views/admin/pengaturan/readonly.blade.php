{{-- Branding Header --}}
<div class="flex items-center gap-6 mb-10">
    @if($setting->logo)
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Lembaga" class="h-20 w-20 rounded-full shadow-md object-cover">
    @else
        <div class="h-20 w-20 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 font-bold text-3xl select-none">?</div>
    @endif
    <div>
        <h2 class="text-3xl font-bold text-emerald-700 font-serif tracking-wide">{{ $setting->nama_lembaga ?? 'Nama Lembaga' }}</h2>
        <p class="text-gray-500 mt-1 text-sm">Platform Zakat yang Amanah, Profesional, dan Terpercaya</p>
    </div>
</div>

{{-- Informasi Lembaga --}}
<section class="space-y-8">
    <h2 class="text-2xl font-semibold text-gray-800 border-l-8 border-emerald-600 pl-5 mb-6 flex items-center gap-3">
        <x-heroicon-o-information-circle class="w-7 h-7 text-emerald-600"/>
        Informasi Lembaga
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 text-base leading-relaxed">
    <div class="flex items-start gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <x-heroicon-o-envelope class="w-6 h-6 text-emerald-600 mt-1"/>
        <div>
            <p class="font-semibold text-sm text-gray-500">Email</p>
            <p class="text-gray-800">{{ $setting->email ?? '-' }}</p>
        </div>
    </div>

    <div class="flex items-start gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <x-heroicon-o-phone class="w-6 h-6 text-emerald-600 mt-1"/>
        <div>
            <p class="font-semibold text-sm text-gray-500">No. HP</p>
            <p class="text-gray-800">{{ $setting->telepon ?? '-' }}</p>
        </div>
    </div>

    <div class="md:col-span-2 flex items-start gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <x-heroicon-o-map-pin class="w-6 h-6 text-emerald-600 mt-1"/>
        <div>
            <p class="font-semibold text-sm text-gray-500">Alamat</p>
            <p class="text-gray-800">{{ $setting->alamat ?? '-' }}</p>
        </div>
    </div>
</div>
</section>

{{-- Branding & Notifikasi --}}
<section class="space-y-8">
    <h2 class="text-2xl font-semibold text-gray-800 border-l-8 border-indigo-600 pl-5 mb-6 flex items-center gap-3">
        <x-heroicon-o-paint-brush class="w-7 h-7 text-indigo-600"/>
        Branding & Notifikasi
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-gray-700 text-base leading-relaxed">
        <div>
            <p class="font-semibold mb-1">Logo Website</p>
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Lembaga" class="h-20 mt-2 rounded shadow-sm object-contain">
            @else
                <p class="italic text-gray-500 mt-2">Belum diatur</p>
            @endif
        </div>
        <div class="md:col-span-2">
            <p class="font-semibold mb-1">Pesan Notifikasi Default</p>
            <p class="whitespace-pre-line">{{ $setting->pesan_notifikasi ?? 'Belum diatur' }}</p>
        </div>
    </div>
</section>

{{-- Ketentuan Zakat --}}
<section class="space-y-8">
    <h2 class="text-2xl font-semibold text-gray-800 border-l-8 border-blue-600 pl-5 mb-6 flex items-center gap-3">
        <x-heroicon-o-book-open class="w-7 h-7 text-blue-600"/>
        Ketentuan Zakat
    </h2>

    @if($data->isEmpty())
        <p class="text-gray-500 italic">Belum ada ketentuan zakat yang ditambahkan.</p>
    @else
        @foreach($data as $jenis => $items)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-blue-700 mb-4 border-b border-blue-300 pb-1">{{ ucfirst($jenis) }}</h3>
                <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
                    <table class="w-full min-w-max table-auto text-gray-700">
                        <thead class="bg-gray-100 font-semibold text-sm text-left">
                            <tr>
                                <th class="px-5 py-3 border-r border-gray-300">Parameter</th>
                                <th class="px-5 py-3 border-r border-gray-300">Nilai</th>
                                <th class="px-5 py-3 border-r border-gray-300">Satuan</th>
                                <th class="px-5 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr class="border-t border-gray-200 hover:bg-blue-50 transition">
                                    <td class="px-5 py-3 border-r border-gray-300">{{ $item->parameter }}</td>
                                    <td class="px-5 py-3 border-r border-gray-300">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                                    <td class="px-5 py-3 border-r border-gray-300">{{ $item->satuan }}</td>
                                    <td class="px-5 py-3">{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</section>

{{-- Role Default --}}
<section class="space-y-6">
    <h2 class="text-2xl font-semibold text-gray-800 border-l-8 border-purple-600 pl-5 mb-6 flex items-center gap-3">
        <x-heroicon-o-shield-check class="w-7 h-7 text-purple-600"/>
        Manajemen Akses
    </h2>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Role Default Pengguna Baru</label>
        <p class="text-gray-800 text-lg font-medium">{{ ucfirst($setting->default_role ?? 'Donatur') }}</p>
    </div>
</section>
