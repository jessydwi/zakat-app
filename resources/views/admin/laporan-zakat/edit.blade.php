@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Edit Transaksi Zakat</h1>
                    <p class="text-yellow-100 mt-2 text-lg">Perbarui informasi zakat yang sudah tercatat dengan lengkap</p>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white bg-opacity-5 rounded-full"></div>
            </div>

            <!-- Form Section -->
            <form action="{{ route('admin.laporan-zakat.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                {{-- Flash Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-6 animate-pulse">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    <ul class="list-disc pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Muzakki --}}
                <div class="space-y-3">
                    <label for="muzakki_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Muzakki</label>
                    <div class="relative group">
                        <select id="muzakki_id" name="muzakki_id"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            @foreach($muzakki as $m)
                                <option value="{{ $m->id }}" {{ $transaksi->muzakki_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('muzakki_id') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Nama --}}
                <div class="space-y-3">
                    <label for="nama" class="block text-sm font-semibold text-gray-800 tracking-wide">Nama</label>
                    <div class="relative group">
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $transaksi->nama) }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md" required>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @error('nama') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="space-y-3">
                    <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-800 tracking-wide">Jenis Kelamin</label>
                    <div class="relative group">
                        <select id="jenis_kelamin" name="jenis_kelamin"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $transaksi->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $transaksi->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('jenis_kelamin') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Kontak --}}
                <div class="space-y-3">
                    <label for="kontak" class="block text-sm font-semibold text-gray-800 tracking-wide">Kontak</label>
                    <div class="relative group">
                        <input type="text" id="kontak" name="kontak" value="{{ old('kontak', $transaksi->kontak) }}"
                               placeholder="Masukkan nomor kontak"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md">
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    @error('kontak') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Tanggal --}}
                <div class="space-y-3">
                    <label for="tanggal" class="block text-sm font-semibold text-gray-800 tracking-wide">Tanggal</label>
                    <div class="relative group">
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $transaksi->tanggal) }}"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md">
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @error('tanggal') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Zakat --}}
                <div class="space-y-3">
                    <label for="jenis_zakat_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Jenis Zakat</label>
                    <div class="relative group">
                        <select id="jenis_zakat_id" name="jenis_zakat_id"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            @foreach($jenisZakat as $jz)
                                <option value="{{ $jz->id }}" {{ $transaksi->jenis_zakat_id == $jz->id ? 'selected' : '' }}>
                                    {{ $jz->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('jenis_zakat_id') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Metode Pembayaran --}}
                <div class="space-y-3">
                    <label for="metode_pembayaran_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Metode Pembayaran</label>
                    <div class="relative group">
                        <select id="metode_pembayaran_id" name="metode_pembayaran_id"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            @foreach($metodePembayaran as $mp)
                                <option value="{{ $mp->id }}" {{ $transaksi->metode_pembayaran_id == $mp->id ? 'selected' : '' }}>
                                    {{ $mp->nama_metode }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('metode_pembayaran_id') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Nominal --}}
                <div class="space-y-3">
                    <label for="nominal" class="block text-sm font-semibold text-gray-800 tracking-wide">Nominal</label>
                    <div class="relative group">
                        <input type="number" id="nominal" name="nominal" value="{{ old('nominal', $transaksi->nominal) }}"
                               placeholder="Masukkan nominal zakat"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md" required>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    @error('nominal') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Amil --}}
            <div class="space-y-3">
                <label for="amil_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Amil</label>
                <div class="relative group">
                    <select id="amil_id" name="amil_id"
                            class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                        <option value="">-- Pilih Amil --</option>
                        @foreach($amils as $amil)
                            <option value="{{ $amil->id }}" {{ $transaksi->amil_id == $amil->id ? 'selected' : '' }}>
                                {{ $amil->user->nama ?? 'Tanpa Nama' }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                @error('amil_id') 
                    <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> 
                @enderror
            </div>
                {{-- Status --}}
                <div class="space-y-3">
                    <label for="status" class="block text-sm font-semibold text-gray-800 tracking-wide">Status</label>
                    <div class="relative group">
                        <select id="status" name="status"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            <option value="terbayar" {{ $transaksi->status == 'terbayar' ? 'selected' : '' }}>Terbayar</option>
                            <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-yellow-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('status') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Detail JSON --}}
                <div class="space-y-3">
                    <label for="detail_json" class="block text-sm font-semibold text-gray-800 tracking-wide">Detail Tambahan (JSON)</label>
                    <div class="relative group">
                        <textarea id="detail_json" name="detail_json" rows="4"
                                  placeholder="Masukkan detail tambahan dalam format JSON"
                                  class="w-full pl-4 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md resize-vertical">{{ old('detail_json', $transaksi->detail_json) }}</textarea>
                    </div>
                    @error('detail_json') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="space-y-3">
                    <label for="bukti_pembayaran" class="block text-sm font-semibold text-gray-800 tracking-wide">Bukti Pembayaran</label>
                    <div class="relative group">
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                               accept="image/*,application/pdf"
                               class="w-full pl-4 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                        @if($transaksi->buktiPembayaran)
                            <p class="mt-2 text-sm text-gray-600">
                                File saat ini:
                                <a href="{{ $transaksi->buktiPembayaran->file_url }}" target="_blank" class="text-blue-600 underline hover:text-blue-800 transition-colors duration-300">
                                    Lihat Bukti
                                </a>
                            </p>
                        @endif
                    </div>
                    @error('bukti_pembayaran') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex justify-end pt-6 border-t border-gray-100 space-x-4">
                    <a href="{{ route('admin.laporan.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl shadow-md hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 text-white font-bold rounded-xl shadow-lg hover:from-yellow-600 hover:via-orange-600 hover:to-red-600 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }

    /* Additional modern enhancements */
    .shadow-3xl {
        box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
    }

    /* Smooth scrolling for better UX */
    html {
        scroll-behavior: smooth;
    }

    /* Custom focus styles for better accessibility */
    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    /* Hover effects for interactive elements */
    button:hover, a:hover {
        transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-4xl {
            max-width: 100%;
            margin: 0 1rem;
        }
        
        .px-8 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .py-12 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    }
</style>
@endsection