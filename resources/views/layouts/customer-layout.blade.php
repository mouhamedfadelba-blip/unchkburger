<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'UNCHK Burger') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFCFB] font-sans antialiased text-slate-900">
    @include('layouts.customer-nav')

        <div class="fixed top-0 right-0 -z-10 opacity-10">
            <svg width="600" height="600" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F97316"
                      d="M45.7,-77.2C58.9,-70.7,69.1,-58.3,77.3,-44.6C85.5,-30.9,91.8,-15.5,91.2,-0.3C90.7,14.8,83.3,29.7,73.6,41.2C63.8,52.8,51.7,61.1,38.7,68.4C25.7,75.7,12.8,82.1,-1,83.9C-14.8,85.6,-29.6,82.8,-43,75.7C-56.5,68.6,-68.6,57.3,-76.3,43.7C-84,30.1,-87.3,14.1,-86.3,1.3C-85.3,-11.5,-80.1,-21.1,-72.6,-34.1C-65.1,-47.1,-55.4,-63.5,-41.8,-69.8C-28.3,-76.1,-14.1,-72.3,0.8,-73.7C15.8,-75.1,32.5,-83.8,45.7,-77.2Z"
                      transform="translate(100 100)"/>
            </svg>
        </div>

        <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <footer class="mt-20 border-t border-slate-100 py-10 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} UNCHK Burger - Le goût du vrai.
        </footer>
    </body>
</html>
