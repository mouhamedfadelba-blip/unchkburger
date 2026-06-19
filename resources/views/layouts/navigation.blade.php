<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2">
                        <div class="bg-orange-500 p-2 rounded-xl shadow-lg shadow-orange-200">
                            <span class="text-2xl">🍔</span>
                        </div>
                        <span class="font-black text-xl tracking-tight text-slate-800">UNCHK<span class="text-orange-500">BURGER</span></span>
                    </a>
                </div>

                <div class="hidden space-x-4 sm:flex">
                    <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')" class="text-sm font-bold">
                        {{ __('Accueil') }}
                    </x-nav-link>

                    <x-nav-link href="/catalogue" :active="request()->is('catalogue')" class="text-sm font-bold">
                        {{ __('La Carte') }}
                    </x-nav-link>

                    <x-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')" class="text-sm font-bold">
                        {{ __('Historique') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('card.index') }}" class="relative p-3 bg-slate-50 rounded-full hover:bg-orange-50 hover:text-orange-600 transition duration-300 group">
                    <span class="text-xl">🛒</span>
                    @if(count(session('card', [])) > 0)
                        <span class="absolute -top-1 -right-1 bg-orange-600 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full ring-4 ring-white animate-bounce">
                            {{ count(session('card', [])) }}
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-4 py-2 bg-slate-900 text-white rounded-full hover:bg-slate-800 transition shadow-md">
                            <div class="text-xs font-bold uppercase tracking-widest">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">👤 Mon Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                🚪 Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-3 rounded-xl text-slate-500 hover:bg-slate-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
