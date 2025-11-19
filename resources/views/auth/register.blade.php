<x-guest-layout> <!-- Session Status --> <x-auth-session-status class="mb-6" :status="session('status')" />

<div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 lg:grid-cols-2 bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-fade-in transition-all duration-700 hover:shadow-3xl hover:scale-105">

    <!-- Kiri: Branding / Ilustrasi -->
    <div class="hidden lg:flex items-center justify-center bg-gradient-to-br from-green-300 via-green-200 to-green-100 text-gray-800 p-12 relative overflow-hidden">
        <!-- Background Pattern for Elegance -->
        <div class="absolute inset-0 bg-black bg-opacity-5"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white bg-opacity-20 rounded-full -translate-x-20 -translate-y-20"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-white bg-opacity-20 rounded-full translate-x-16 translate-y-16"></div>
        <div class="relative text-center space-y-8 z-10">
            <div class="mx-auto h-24 w-24 bg-white bg-opacity-30 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg">
                <svg class="h-12 w-12 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h2 class="text-5xl font-extrabold tracking-tight">Daftar Akun Baru</h2>
            <p class="text-xl opacity-90 leading-relaxed">Buat akun Anda untuk mulai menggunakan layanan kami</p>
            <div class="mt-6">
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-gray-800 border-opacity-30 rounded-full text-gray-800 hover:bg-gray-800 hover:bg-opacity-10 transition duration-300 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Sudah punya akun? Masuk
                </a>
            </div>
        </div>
    </div>

    <!-- Kanan: Form Register -->
    <div class="p-8 sm:p-12 lg:p-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-md mx-auto">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Register</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Masukkan detail Anda untuk membuat akun baru</p>
            <form method="POST" action="{{ route('register') }}" class="space-y-8 animate-slide-up delay-300">
                @csrf

                <!-- Nama -->
                <div>
                    <x-input-label for="nama" :value="__('Nama')" />
                    <x-text-input id="nama" name="nama" type="text" :value="old('nama')" required autofocus autocomplete="name"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="email"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan alamat email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- No HP -->
                <div>
                    <x-input-label for="no_hp" :value="__('No HP')" />
                    <x-text-input id="no_hp" name="no_hp" type="tel" :value="old('no_hp')" required autocomplete="tel"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan nomor HP" />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Alamat -->
                <div>
                    <x-input-label for="alamat" :value="__('Alamat')" />
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Pekerjaan -->
                <div>
                    <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                    <x-text-input id="pekerjaan" name="pekerjaan" type="text" :value="old('pekerjaan')" required autocomplete="organization-title"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan pekerjaan" />
                    <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" required autocomplete="new-password"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="mt-2 block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Konfirmasi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between">
                    <a class="text-sm text-green-600 hover:text-green-500 font-medium underline" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>
                    <x-primary-button class="inline-flex items-center px-6 py-3 text-base font-semibold rounded-lg bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300 shadow-md hover:shadow-lg">
                        Register
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-guest-layout>
