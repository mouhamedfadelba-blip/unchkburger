<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-orange-50/50">
    <div>
        <a href="/" class="flex flex-col items-center gap-2 group">
            <span class="text-6xl transform group-hover:scale-110 transition duration-300">🍔</span>
            <span class="font-bold text-3xl text-orange-600 tracking-tight">UNCHK<span class="text-gray-900">BURGER</span></span>
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl shadow-orange-200/50 overflow-hidden sm:rounded-3xl border border-orange-100">
        {{ $slot }}
    </div>

    <p class="mt-8 text-gray-400 text-sm">
        &copy; {{ date('Y') }} UNCHK Burger - Le goût avant tout.
    </p>
</div>
</body>
</html>
