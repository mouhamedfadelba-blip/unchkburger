<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manager - UNCHK Burger</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans antialiased no-scrollbar">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl">
            <div class="p-6">
                <span class="font-bold text-xl tracking-tight">UNCHK<span class="text-indigo-400">MANAGER</span></span>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('manager.dashboard') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 {{ request()->routeIs('manager.dashboard') ? 'bg-indigo-600' : '' }}">
                    <span>📊</span> Tableau de bord
                </a>
                <a href="{{ route('manager.orders.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800">
                    <span>📦</span> Commandes
                </a>
                <a href="{{ route('manager.burgers.index') }}"
                   class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800">
                    <span>🍔</span> Burgers
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-slate-400 hover:text-white text-sm">Déconnexion</button>
                </form>
            </div>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow-sm p-6">
                <h2 class="font-bold text-xl text-slate-800">{{ $header ?? 'Tableau de bord' }}</h2>
            </header>

            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>
    @stack('scripts')
    </body>
</html>
