<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Muzakki')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="min-h-screen flex">

        <!-- Sidebar (Mirip Admin) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shadow-sm rounded-tr-xl">
            <div class="p-6 space-y-6">
                <!-- Branding -->
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-green-700 tracking-tight flex items-center justify-center gap-2">
                        <i class="fas fa-mosque text-green-600"></i>
                        Zakat App
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Halo, <span class="font-semibold">{{ Auth::user()->name ?? 'Muzakki' }}</span>
                    </p>
                </div>

                <!-- Navigasi (style mirip admin) -->
                <nav class="space-y-1 text-[15px] font-medium">
                    <a href="{{ route('muzaki.dashboard') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                        <i class="fas fa-home mr-3 text-green-600"></i> Dashboard
                    </a>

                    <a href="{{ route('muzaki.bayar') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                        <i class="fas fa-wallet mr-3 text-green-600"></i> Form Pembayaran
                    </a>

                    <a href="{{ route('muzaki.kalkulator') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                        <i class="fas fa-calculator mr-3 text-green-600"></i> Kalkulator Zakat
                    </a>

                    <a href="{{ route('muzaki.riwayat') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                        <i class="fas fa-history mr-3 text-green-600"></i> Riwayat Pembayaran
                    </a>

                    <a href="{{ route('muzaki.informasi') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                        <i class="fas fa-book-open mr-3 text-green-600"></i> Edukasi Zakat
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-6 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center w-full px-4 py-2 rounded-lg text-red-600 font-medium hover:bg-red-50 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
                <p class="text-xs text-gray-500 text-center mt-3">© {{ date('Y') }} Zakat App</p>
            </div>
        </aside>

        <!-- Konten Utama (Mirip Admin) -->
        <main class="flex-1 p-8">
            <!-- Header / Breadcrumb -->
            <header class="mb-6 border-b border-gray-200 pb-4">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-green-800">@yield('title')</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <!-- Notifikasi & Profil -->
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-green-600 hover:text-green-700 transition" aria-label="Notifications">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full">2</span>
                        </button>
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->email ?? 'muzakki@zakat.com' }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Isi Halaman -->
            <div class="bg-white rounded-xl shadow p-6">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>
