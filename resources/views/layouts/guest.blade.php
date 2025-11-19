<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Background Style -->
    <style>
        body {
            background-image: url('/images/Masjid-PNG.png'); /* Ganti dengan path gambar kamu */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .bg-overlay {
            background-color: rgba(255, 255, 255, 0.85); /* semi transparan putih */
            backdrop-filter: blur(2px);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-screen-lg bg-overlay dark:bg-gray-800 shadow-xl rounded-2xl p-8 sm:p-10 border border-gray-200 dark:border-gray-700 transition-all duration-500 hover:shadow-2xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
