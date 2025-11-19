@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Edit Distribusi Zakat</h1>
                    <p class="text-blue-100 mt-2 text-lg">Perbarui informasi distribusi zakat dengan lengkap dan akurat</p>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white bg-opacity-5 rounded-full"></div>
            </div>

            <!-- Form Section -->
            <form action="{{ route('admin.laporan-zakat.update-distribusi', $distribusi->id) }}" method="POST" class="p-8 space-y-8">
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

                {{-- Mustahik --}}
                <div class="space-y-3">
                    <label for="mustahik_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Mustahik</label>
                    <div class="relative group">
                        <select id="mustahik_id" name="mustahik_id"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            <option value="">Pilih Mustahik</option>
                            @foreach($mustahik as $m)
                                <option value="{{ $m->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('mustahik_id') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Bantuan --}}
                <div class="space-y-3">
                    <label for="jenis_bantuan_id" class="block text-sm font-semibold text-gray-800 tracking-wide">Jenis Bantuan</label>
                    <div class="relative group">
                        <select id="jenis_bantuan_id" name="jenis_bantuan_id"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            <option value="">Pilih Jenis Bantuan</option>
                            @foreach($jenisBantuan as $jb)
                                <option value="{{ $jb->id }}" {{ old('jenis_bantuan_id', $distribusi->jenis_bantuan_id) == $jb->id ? 'selected' : '' }}>
                                    {{ $jb->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('jenis_bantuan_id') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Jumlah --}}
                <div class="space-y-3">
                    <label for="jumlah" class="block text-sm font-semibold text-gray-800 tracking-wide">Jumlah</label>
                    <div class="relative group">
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $distribusi->jumlah) }}"
                               placeholder="Masukkan jumlah distribusi"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md" required min="0" step="0.01">
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    @error('jumlah') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Detail JSON --}}
                <div class="space-y-3">
                    <label for="detail_json" class="block text-sm font-semibold text-gray-800 tracking-wide">Detail Tambahan (JSON)</label>
                    <div class="relative group">
                        <textarea id="detail_json" name="detail_json" rows="4"
                                  placeholder="Masukkan detail tambahan dalam format JSON"
                                  class="w-full pl-4 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md resize-vertical">{{ old('detail_json', json_encode($distribusi->detail_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
                    </div>
                    @error('detail_json') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:via-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
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
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Hover effects for interactive elements */
    button:hover {
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