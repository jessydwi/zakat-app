@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Edit User</h1>
                    <p class="text-emerald-100 mt-2 text-lg">Perbarui informasi pengguna dengan lengkap dan akurat</p>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white bg-opacity-5 rounded-full"></div>
            </div>

            <!-- Form Section -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 space-y-8" x-data="{ role: '{{ old('role', $user->role) }}' }">
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

                {{-- Nama --}}
                <div class="space-y-3">
                    <label for="nama" class="block text-sm font-semibold text-gray-800 tracking-wide">Nama Lengkap</label>
                    <div class="relative group">
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md" required>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @error('nama') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-3">
                    <label for="email" class="block text-sm font-semibold text-gray-800 tracking-wide">Email</label>
                    <div class="relative group">
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               placeholder="Masukkan alamat email"
                               class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md" required>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @error('email') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-3">
                    <label for="role" class="block text-sm font-semibold text-gray-800 tracking-wide">Peran</label>
                    <div class="relative group">
                        <select id="role" name="role" x-model="role"
                                class="w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md appearance-none" required>
                            @foreach(['admin','muzaki','mustahiq'] as $r)
                                <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg class="absolute right-4 top-4 h-6 w-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @error('role') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <input type="checkbox" id="is_active" name="is_active" value="1" @checked($user->is_active)
                           class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-all duration-300">
                    <label for="is_active" class="text-sm font-semibold text-gray-800 cursor-pointer">Status Aktif</label>
                    <span class="text-xs text-gray-500">(Centang untuk mengaktifkan akun)</span>
                </div>

                {{-- Field Tambahan untuk Muzaki --}}
                <template x-if="role === 'muzaki'">
                    <div class="mt-10 space-y-8 border-t border-gray-200 pt-8 animate-fade-in">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Data Muzaki
                        </h2>

                        <div class="space-y-3">
                            <label for="no_hp" class="block text-sm font-semibold text-gray-800 tracking-wide">Nomor HP</label>
                            <div class="relative group">
                                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $muzaki->no_hp ?? '') }}"
                                       placeholder="Masukkan nomor HP"
                                       class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md">
                                <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            @error('no_hp') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-3">
                            <label for="alamat" class="block text-sm font-semibold text-gray-800 tracking-wide">Alamat</label>
                            <div class="relative group">
                                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $muzaki->alamat ?? '') }}"
                                       placeholder="Masukkan alamat lengkap"
                                       class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md">
                                <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            @error('alamat') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-3">
                            <label for="pekerjaan" class="block text-sm font-semibold text-gray-800 tracking-wide">Pekerjaan</label>
                            <div class="relative group">
                                <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $muzaki->pekerjaan ?? '') }}"
                                       placeholder="Masukkan pekerjaan"
                                       class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm group-hover:shadow-md">
                                <svg class="absolute left-4 top-4 h-6 w-6 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8"></path>
                                </svg>
                            </div>
                            @error('pekerjaan') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </template>

                {{-- Field Tambahan untuk Admin (Amil) --}}
                <template x-if="role === 'admin'">
                    <div class="mt-10 space-y-8 border-t border-gray-200 pt-8 animate-fade-in">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Data Amil
                        </h2>

                        <div class="space-y-3">
                            <label for="jabatan" class="block text-sm font-semibold text-gray-800 tracking-wide">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $amil->jabatan ?? '') }}"
                                   placeholder="Masukkan jabatan"
                                   class="w-full pl-4 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md">
                            @error('jabatan') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-3">
                            <label for="wilayah_tugas" class="block text-sm font-semibold text-gray-800 tracking-wide">Wilayah Tugas</label>
                            <input type="text" id="wilayah_tugas" name="wilayah_tugas" value="{{ old('wilayah_tugas', $amil->wilayah_tugas ?? '') }}"
                                   placeholder="Masukkan wilayah tugas"
                                   class="w-full pl-4 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-300 bg-gray-50 focus:bg-white shadow-sm hover:shadow-md">
                            @error('wilayah_tugas') <span class="text-red-600 text-sm mt-1 block animate-fade-in">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </template>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600 text-white font-bold rounded-xl shadow-lg hover:from-emerald-700 hover:via-teal-600 hover:to-cyan-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
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
    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Hover effects for interactive elements */
    button:hover {
        transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-3xl {
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