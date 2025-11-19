<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="w-full max-w-screen-xl mx-auto grid grid-cols-1 lg:grid-cols-2 bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-fade-in transition-all duration-700 hover:shadow-3xl hover:scale-105">
                    
<!-- Kiri: Branding / Ilustrasi --> 
 <div class="hidden lg:flex items-center justify-center bg-gradient-to-br from-green-300 via-green-200 to-green-100 text-gray-800 p-12 relative overflow-hidden">
     <!-- Background Pattern for Elegance --> 
      <div class="absolute inset-0 bg-black bg-opacity-5">
      </div> <div class="absolute top-0 left-0 w-40 h-40 bg-white bg-opacity-20 rounded-full -translate-x-20 -translate-y-20"></div>
       <div class="absolute bottom-0 right-0 w-32 h-32 bg-white bg-opacity-20 rounded-full translate-x-16 translate-y-16"></div> 
       <div class="relative text-center space-y-8 z-10"> 
        <div class="mx-auto h-24 w-24 bg-white bg-opacity-30 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg"> 
            <svg class="h-12 w-12 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path> </svg> 
        </div> <h2 class="text-5xl font-extrabold tracking-tight">Welcome Back</h2> <p class="text-xl opacity-90 leading-relaxed">Sign in to your account and continue your journey with us</p> <div class="mt-6"> <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-gray-800 border-opacity-30 rounded-full text-gray-800 hover:bg-gray-800 hover:bg-opacity-10 transition duration-300 backdrop-blur-sm"> 
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
            </path> </svg> Create New Account </a> </div> </div> </div> <!-- Kanan: Form Login --> <div class="p-8 sm:p-12 lg:p-16 bg-gray-50 dark:bg-gray-800"> <div class="max-w-md mx-auto"> <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Sign In</h3> 
            <p class="text-gray-600 dark:text-gray-400 mb-8">Enter your credentials to access your account</p>
             <form method="POST" action="{{ route('login') }}" class="space-y-8 animate-slide-up delay-300">
                 @csrf

                    <!-- Email -->
        <div class="relative">
            <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
            <div class="relative">
                <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"
                    class="block w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-300 transition duration-300 shadow-sm hover:shadow-md"
                    placeholder="your@email.com" />
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $errors->first('email') }}
            </x-input-error>
        </div>

        <!-- Password -->
        <div class="relative">
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" />
            <div class="relative">
                <x-text-input id="password" name="password" type="password" required autocomplete="current-password"
                    class="block w-full pl-12 pr-4 py-4 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-green-300 focus:border-green-300 transition duration-300 shadow-sm hover:shadow-md"
                    placeholder="••••••••" />
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $errors->first('password') }}
            </x-input-error>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-5 w-5 text-green-400 border-gray-300 dark:border-gray-600 rounded focus:ring-green-300 focus:ring-2" />
                <span class="ml-3 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-green-400 hover:text-green-300 dark:text-green-300 dark:hover:text-green-200 font-semibold underline transition duration-200">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full py-4 text-lg font-bold rounded-xl bg-gradient-to-r from-green-300 via-green-200 to-green-100 hover:from-green-400 hover:via-green-300 hover:to-green-200 focus:ring-4 focus:ring-green-300 focus:ring-offset-2 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center text-gray-800">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Mobile Register Link -->
        <div class="lg:hidden text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-green-400 hover:text-green-300 dark:text-green-300 dark:hover:text-green-200 underline">
                    Sign up here
                </a>
            </p>
        </div>
    </form>
</div>
    
</x-guest-layout>
