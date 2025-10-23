<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Zakat Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahkan Font Awesome untuk ikon yang lebih kaya -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom animations for more professional feel */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s;
        }
        .sidebar-link:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-emerald-25 to-emerald-100 font-sans text-gray-800 antialiased fade-in">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white text-emerald-800 shadow-2xl border-r border-emerald-200 rounded-r-xl transform transition-transform duration-300 ease-in-out">
            <div class="p-6 text-2xl font-bold tracking-wide border-b border-emerald-200 flex items-center gap-3">
                <i class="fas fa-mosque text-emerald-600 text-3xl animate-pulse"></i>
                <span class="text-emerald-700">ZAKAT SYSTEM</span>
            </div>
            <nav class="mt-8 space-y-2 px-6 text-[15px] font-medium">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-tachometer-alt text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Dashboard</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('admin.manajemen-zakat.index') }}" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-hand-holding-heart text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Manajemen Zakat</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('admin.manajemen-mustahik.index') }}" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-users text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Manajemen Mustahiq</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-chart-line text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Laporan & Rekapitulasi</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-user-cog text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Manajemen User</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
                <a href="#" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-emerald-100 hover:shadow-lg transition-all duration-300 group relative">
                    <i class="fas fa-cogs text-emerald-600 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Pengaturan</span>
                    <div class="absolute inset-0 bg-emerald-500 opacity-0 group-hover:opacity-10 rounded-xl transition-opacity duration-300"></div>
                </a>
            </nav>
            <!-- Footer Sidebar -->
            <div class="mt-auto p-6 border-t border-emerald-200">
                <p class="text-xs text-emerald-600 text-center">© 2023 Zakat System. All rights reserved.</p>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="bg-white shadow-xl px-8 py-5 flex justify-between items-center border-b border-emerald-200 rounded-bl-xl">
                <div class="flex-1">
                    <nav class="flex mb-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-900">
                                    <i class="fas fa-home mr-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-emerald-400 mx-1"></i>
                                    <span class="text-sm font-medium text-emerald-500">@yield('title')</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold text-emerald-900 tracking-tight">@yield('title')</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <button class="relative p-2 text-emerald-600 hover:text-emerald-800 transition-colors duration-200" aria-label="Notifications">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                    </button>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->email ?? 'admin@zakat.com', 0, 1)) }}
                        </div>
                        <span class="text-emerald-700 font-semibold hidden sm:block">{{ Auth::user()->email ?? 'admin@zakat.com' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-8 bg-white/95 backdrop-blur-sm rounded-tl-xl shadow-inner">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

</body>
</html>
