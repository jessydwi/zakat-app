<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white dark:bg-gray-900 shadow-2xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-center text-emerald-600 mb-4">
            🔒 Reset Password
        </h2>
        <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
            Masukkan email dan password baru untuk melanjutkan
        </p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600"
                              type="email" name="email" :value="old('email', $request->email)" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password Baru')" />
                <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Submit -->
            <div>
                <x-primary-button class="w-full py-3 text-lg font-bold rounded-xl bg-gradient-to-r from-green-400 via-green-300 to-green-200 hover:from-green-500 hover:via-green-400 hover:to-green-300 focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center text-gray-800">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2h6m-8 6h8m-8 6h8M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Reset Password
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
