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
                    <x-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')">
                        {{ __('Mon espace') }}
                    </x-nav-link>

                    <x-nav-link :href="route('customer.catalogues.index')" :active="request()->routeIs('customer.catalogues.*')">
                        {{ __('Catalogue') }}
                    </x-nav-link>

                    <x-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')">
                        {{ __('Mes commandes') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('customer.cards.index') }}" class="relative p-3 bg-slate-50 rounded-full hover:bg-orange-50 hover:text-orange-600 transition duration-300 group">
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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-100 shadow-lg absolute w-full">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')">
                🏠 {{ __('Accueil') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('customer.catalogues.index')" :active="request()->routeIs('catalogue.index')">
                🍔 {{ __('La Carte') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('customer.cards.index')" :active="request()->routeIs('card.index')">
                🛒 {{ __('Mon Panier') }}
                @if(count(session('card', [])) > 0)
                    <span class="ml-2 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ count(session('card', [])) }}</span>
                @endif
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')">
                📜 {{ __('Historique') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-100 bg-slate-50">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 {{ __('Mon Profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="text-red-600 font-bold">
                        🚪 {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
