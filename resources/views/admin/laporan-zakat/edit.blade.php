@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Edit Transaksi Zakat</h1>
                <p class="text-yellow-100">Perbarui informasi zakat yang sudah tercatat</p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.laporan-zakat.update', $transaksi->id) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Muzakki -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Muzakki</label>
                    <select name="muzakki_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($muzakki as $m)
                            <option value="{{ $m->id }}" {{ $transaksi->muzakki_id == $m->id ? 'selected' : '' }}>
                                {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $transaksi->nama) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ $transaksi->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $transaksi->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Kontak -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kontak</label>
                    <input type="text" name="kontak" value="{{ old('kontak', $transaksi->kontak) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Tanggal -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $transaksi->tanggal) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Jenis Zakat -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Jenis Zakat</label>
                    <select name="jenis_zakat_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($jenisZakat as $jz)
                            <option value="{{ $jz->id }}" {{ $transaksi->jenis_zakat_id == $jz->id ? 'selected' : '' }}>
                                {{ $jz->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="metode_pembayaran_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($metodePembayaran as $mp)
                            <option value="{{ $mp->id }}" {{ $transaksi->metode_pembayaran_id == $mp->id ? 'selected' : '' }}>
                                {{ $mp->nama_metode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nominal</label>
                    <input type="number" name="nominal" value="{{ old('nominal', $transaksi->nominal) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="terbayar" {{ $transaksi->status == 'terbayar' ? 'selected' : '' }}>Terbayar</option>
                        <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <!-- Detail JSON -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Detail Tambahan (JSON)</label>
                    <textarea name="detail_json" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('detail_json', $transaksi->detail_json) }}</textarea>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                           accept="image/*,application/pdf">
                    @if($transaksi->buktiPembayaran)
                        <p class="mt-2 text-sm text-gray-600">
                            File saat ini: 
                            <a href="{{ $transaksi->buktiPembayaran->file_url }}" target="_blank" class="text-blue-600 underline">
                                Lihat Bukti
                            </a>
                        </p>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.laporan.index') }}" class="px-6 py-2 bg-gray-300 rounded-md">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
