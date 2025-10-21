<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <div class="flex min-h-screen">
        <aside class="w-64 bg-blue-900 text-white">
            <div class="p-4 text-xl font-bold border-b border-blue-700">ZAKAT SYSTEM</div>
            <nav class="mt-4 space-y-2 px-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-blue-700">Dashboard</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700">Manajemen Zakat</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700">Manajemen Mustahiq</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700">Laporan & Rekapitulasi</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700">Manajemen User</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700">Pengaturan</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Admin</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

</body>
</html>
