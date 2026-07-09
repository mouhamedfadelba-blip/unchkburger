<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'UNCHK Burger') }} - Les meilleurs burgers de la ville</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body
    class="antialiased bg-gray-50s text-gray-900 font-['Instrument_Sans'] selection:bg-orange-500 selection:text-white no-scrollbar overflow-x-hidden">

<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex-shrink-0 flex items-center gap-2">
                <span class="text-3xl">🍔</span>
                <span class="font-bold text-2xl text-orange-600 tracking-tight">UNCHK<span
                        class="text-gray-900">BURGER</span></span>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-gray-600 hover:text-orange-600 font-medium transition">Mon Espace</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-600 font-medium transition">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-full font-semibold transition shadow-md hover:shadow-lg">S'inscrire</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

<main>
    <div class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20">
                <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                            <span
                                class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold mb-4 border border-orange-200">
                                🔥 Le goût à l'état pur
                            </span>
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl leading-tight">
                            <span class="block xl:inline">Vos burgers préférés,</span>
                            <span class="block text-orange-600 xl:inline">préparés avec passion.</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Découvrez nos recettes uniques, préparées à la commande avec des ingrédients frais et
                            locaux. Gagnez du temps en commandant en ligne et récupérez votre repas au comptoir.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('customer.catalogues.index') ?? '#' }}"
                                   class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-orange-600 hover:bg-orange-700 md:py-4 md:text-lg md:px-10 transition transform hover:-translate-y-1 shadow-lg hover:shadow-orange-500/30">
                                    Voir le Menu
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#concept"
                                   class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition">
                                    Notre Concept
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                 src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80"
                 alt="Un délicieux burger appétissant">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/20 to-transparent lg:block hidden"></div>
        </div>
    </div>

    <section id="menu" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-orange-600 font-semibold tracking-wide uppercase">Notre Carte</h2>
                <p class="mt-2 text-4xl font-black tracking-tight text-gray-900">Choisissez votre <span class="text-orange-600">plaisir</span></p>
            </div>

            <div class="space-y-16">
                @foreach($categories as $category)
                    @if($category->burgers->count() > 0)
                        <div>
                            <div class="flex items-center gap-4 mb-8">
                                <h3 class="text-xl font-bold text-gray-800 uppercase tracking-widest">{{ $category->nom }}</h3>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                                @foreach($category->burgers->take(4) as $burger) {{-- .take(4) pour ne pas surcharger l'accueil --}}
                                <div class="group relative bg-gray-50 rounded-3xl p-4 transition-all hover:bg-white hover:shadow-2xl border border-transparent hover:border-orange-100">
                                    <div class="aspect-square overflow-hidden rounded-2xl mb-4 bg-white">
                                        @if($burger->image)
                                            <img src="{{ $burger->image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-5xl">🍔</div>
                                        @endif
                                    </div>

                                    <h4 class="text-lg font-bold text-gray-900">{{ $burger->nom }}</h4>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $burger->description }}</p>

                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-xl font-black text-orange-600">{{ number_format($burger->unit_price, 0, ',', ' ') }} F</span>

                                        @auth
                                            <form action="{{ route('customer.cards.add', $burger) }}" method="POST">
                                                @csrf
                                                <button class="bg-gray-900 text-white p-2 rounded-lg hover:bg-orange-600 transition">+</button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-orange-600 underline">Connectez-vous</a>
                                        @endauth
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-gray-900 hover:bg-orange-600 transition shadow-xl">
                    Créer un compte pour commander 🚀
                </a>
            </div>
        </div>
    </section>

    <div id="concept" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-orange-600 font-semibold tracking-wide uppercase">La différence UNCHK</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Une meilleure façon de manger
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl">🥩</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Viande Fraîche</h3>
                        <p class="text-gray-500">Du bœuf 100% local, jamais congelé, haché sur place tous les matins
                            pour un goût authentique.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Click & Collect</h3>
                        <p class="text-gray-500">Commandez depuis votre canapé. Pas de file d'attente, votre burger vous
                            attend tout chaud au comptoir.</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition">
                        <div class="w-16 h-16 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl">🌿</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Pain Artisanal</h3>
                        <p class="text-gray-500">Nos buns sont préparés par notre boulanger partenaire, moelleux à
                            l'intérieur et dorés à l'extérieur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex justify-center items-center gap-2 mb-4">
            <span class="text-2xl">🍔</span>
            <span class="font-bold text-2xl text-orange-600 tracking-tight">UNCHK<span class="text-orange-500">BURGER</span></span>
        </div>
        <p class="text-gray-400 mb-6">La référence du burger artisanal.</p>
        <p class="text-sm text-gray-500">
            &copy; {{ date('Y') }} UNCHK Burger. Tous droits réservés.
        </p>
    </div>
</footer>

</body>
</html>
