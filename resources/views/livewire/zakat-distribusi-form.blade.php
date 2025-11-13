<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="mb-6 px-6 py-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded-lg font-semibold flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Form --}}
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-share text-emerald-600 text-2xl"></i>
        <h2 class="text-xl font-bold text-emerald-800">Form Distribusi Zakat</h2>
    </div>

    {{-- Form Distribusi --}}
    <form wire:submit.prevent="submit" class="space-y-6">
        {{-- Mustahik --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-user text-emerald-600"></i> Mustahik
            </label>
            <select wire:model="mustahik_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm">
                <option value="">-- Pilih Mustahik --</option>
                @foreach($mustahikList as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
            @error('mustahik_id') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Jenis Bantuan --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-emerald-600"></i> Jenis Bantuan
            </label>
            <select wire:model="jenis_bantuan_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm">
                <option value="">-- Pilih Bantuan --</option>
                @foreach($bantuanList as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_bantuan }}</option>
                @endforeach
            </select>
            @error('jenis_bantuan_id') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Jumlah (kecuali uang-tunai & beasiswa) --}}
        @unless(in_array($jenis_bantuan_slug, ['uang-tunai', 'beasiswa']))
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <i class="fas fa-calculator text-emerald-600"></i>
                    @switch($jenis_bantuan_slug)
                        @case('sembako') Jumlah Paket @break
                        @case('modal-usaha') Jumlah Penerima Modal @break
                        @case('kesehatan') Jumlah Pasien @break
                        @default Jumlah (Total bantuan)
                    @endswitch
                </label>
                <input type="number" wire:model="jumlah" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm" placeholder="Masukkan jumlah" />
                @error('jumlah') 
                    <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                    </span> 
                @enderror
            </div>
        @endunless

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-emerald-600"></i> Tanggal
            </label>
            <input type="date" wire:model="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 bg-white shadow-sm" />
            @error('tanggal') 
                <span class="text-sm text-red-600 mt-1 flex items-center gap-1">
                    <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                </span> 
            @enderror
        </div>

        {{-- Form Modular Berdasarkan Jenis Bantuan --}}
        @isset($jenis_bantuan_slug)
            <div wire:key="form-{{ $jenis_bantuan_slug }}" class="bg-emerald-50 p-4 rounded-lg border-l-4 border-emerald-500">
                @includeIf('livewire.detail-form.' . $jenis_bantuan_slug)
            </div>
        @endisset

        {{-- Tombol Submit --}}
        <div class="pt-4 flex justify-end">
            <button type="submit" wire:loading.attr="disabled" 
                    class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-save"></i>
                <span wire:loading.remove>💾 Simpan Distribusi</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>

