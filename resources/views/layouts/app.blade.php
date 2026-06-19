<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ISI Burger | Le goût avant tout</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <a href="/" class="text-2xl font-black text-orange-600">ISI<span class="text-gray-900">BURGER</span></a>

                <div class="flex items-center gap-6 font-bold text-gray-700">
                    <a href="/" class="hover:text-orange-600">Menu</a>
                    <a href="#" class="hover:text-orange-600">Mes Commandes</a>
                    <a href="#" class="bg-orange-600 text-white px-5 py-2 rounded-full hover:bg-orange-700 transition">Panier (0)</a>
                </div>
            </div>
        </nav>

        <main class="py-10">
            {{ $slot }}
        </main>
    </body>
</html>
