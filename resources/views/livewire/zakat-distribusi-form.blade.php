<div>
    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Distribusi --}}
    <form wire:submit.prevent="submit" class="space-y-5">
        {{-- Mustahik --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mustahik</label>
            <select wire:model="mustahik_id" class="w-full border-gray-300 rounded px-3 py-2">
                <option value="">-- Pilih Mustahik --</option>
                @foreach($mustahikList as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
            @error('mustahik_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Jenis Bantuan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Bantuan</label>
            <select wire:model="jenis_bantuan_id" class="w-full border-gray-300 rounded px-3 py-2">
                <option value="">-- Pilih Bantuan --</option>
                @foreach($bantuanList as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_bantuan }}</option>
                @endforeach
            </select>
            @error('jenis_bantuan_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Jumlah (kecuali uang-tunai & beasiswa) --}}
        @unless(in_array($jenis_bantuan_slug, ['uang-tunai', 'beasiswa']))
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    @switch($jenis_bantuan_slug)
                        @case('sembako') Jumlah Paket @break
                        @case('modal-usaha') Jumlah Penerima Modal @break
                        @case('kesehatan') Jumlah Pasien @break
                        @default Jumlah (Total bantuan)
                    @endswitch
                </label>
                <input type="number" wire:model="jumlah" class="w-full border-gray-300 rounded px-3 py-2" placeholder="Masukkan jumlah" />
                @error('jumlah') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        @endunless

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
            <input type="date" wire:model="tanggal" class="w-full border-gray-300 rounded px-3 py-2" />
            @error('tanggal') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Form Modular Berdasarkan Jenis Bantuan --}}
        @isset($jenis_bantuan_slug)
            <div wire:key="form-{{ $jenis_bantuan_slug }}">
                @includeIf('livewire.detail-form.' . $jenis_bantuan_slug)
            </div>
        @endisset

        {{-- Tombol Submit --}}
        <div class="pt-4">
            <button type="submit" wire:loading.attr="disabled" class="bg-emerald-600 text-white px-5 py-2 rounded hover:bg-emerald-700 transition">
                💾 Simpan Distribusi
            </button>
        </div>
    </form>
</div>
