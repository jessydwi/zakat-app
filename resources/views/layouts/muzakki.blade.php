<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Muzakki</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow p-4">
            <h1 class="text-xl font-bold mb-4">Muzakki Panel</h1>
            <nav class="space-y-2">
                <a href="{{ route('muzakki.dashboard') }}" class="block text-blue-600 hover:underline">Dashboard</a>
                {{-- Tambahkan link lainnya di sini --}}
            </nav>
        </aside>

        {{-- Content --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
