<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Muzakki') - Zakat System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Fade animation */
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sidebar shine hover */
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        .sidebar-link::before {
            content: "";
            position: absolute;
            inset: 0;
            left: -100%;
            background: linear-gradient(90deg, transparent, rgba(16,185,129,0.1), transparent);
            transition: left .5s;
        }
        .sidebar-link:hover::before { left: 100%; }
    </style>

</head>

<body class="bg-gradient-to-br from-emerald-50 via-emerald-25 to-emerald-100 text-gray-800 font-sans fade-in">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl border-r border-emerald-200 rounded-r-xl
               transform transition-transform duration-300 ease-in-out
               -translate-x-full md:translate-x-0 md:relative md:transform-none">

        <!-- Logo -->
        <div class="p-6 text-2xl font-bold tracking-wide border-b border-emerald-200 flex items-center gap-3">
            <i class="fas fa-mosque text-emerald-600 text-3xl animate-pulse"></i>
            <span class="text-emerald-700">ZAKAT SYSTEM</span>
        </div>

        <!-- Menu -->
        <nav class="mt-8 space-y-2 px-6 text-[15px] font-medium">

            <a href="{{ route('muzaki.dashboard') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-home text-emerald-600"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('muzaki.bayar') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-wallet text-emerald-600"></i>
                <span>Form Pembayaran</span>
            </a>

            <a href="{{ route('muzaki.kalkulator') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-calculator text-emerald-600"></i>
                <span>Kalkulator Zakat</span>
            </a>

            <a href="{{ route('muzaki.riwayat') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-history text-emerald-600"></i>
                <span>Riwayat Pembayaran</span>
            </a>

            <a href="{{ route('muzaki.informasi') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-book-open text-emerald-600"></i>
                <span>Edukasi Zakat</span>
            </a>

            <a href="{{ route('muzaki.profil') }}"
                class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 transition-all duration-300">
                <i class="fas fa-user text-emerald-600"></i>
                <span>Profil</span>
            </a>

        </nav>

        <!-- Footer -->
        <div class="mt-auto p-6 border-t border-emerald-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>

            <p class="text-xs text-emerald-600 text-center mt-3">© {{ date('Y') }} Zakat System</p>
        </div>
    </aside>

    <!-- Overlay Mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- MAIN WRAPPER -->
    <div class="flex-1 flex flex-col md:ml-0">

        <!-- TOPBAR -->
        <header class="bg-white shadow-xl px-8 py-5 flex justify-between items-center border-b border-emerald-200 rounded-bl-xl">

            <!-- Left -->
            <div class="flex items-center">

                <!-- Mobile hamburger -->
                <button id="hamburger" class="md:hidden mr-4 p-2 text-emerald-600" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div>
                    <nav class="flex mb-2 text-sm">
                        <ol class="inline-flex items-center space-x-2">
                            <li>
                                <a href="{{ route('muzaki.dashboard') }}"
                                   class="flex items-center text-emerald-700 font-medium">
                                    <i class="fas fa-home mr-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-chevron-right text-emerald-400 mx-1"></i>
                                <span class="text-emerald-500 font-medium">@yield('title')</span>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="text-3xl font-bold text-emerald-900">@yield('title')</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center space-x-4">

                <!-- Bell -->
                <button class="relative p-2 text-emerald-600">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">2</span>
                </button>

                <!-- Avatar -->
                @php
                    $user = Auth::user();
                    $name = $user->name ?? explode('@', $user->email)[0] ?? 'M';
                    $initial = strtoupper(substr($name, 0, 1));
                @endphp

                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        {{ $initial }}
                    </div>
                    <span class="font-semibold text-emerald-700 hidden sm:block">
                        {{ $user->email ?? 'muzakki@zakat.com' }}
                    </span>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8 bg-white/95 backdrop-blur-sm rounded-tl-xl shadow-inner">
            @yield('content')
        </main>

    </div>
</div>

@livewireScripts
@stack('scripts')

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>

</body>
</html>
