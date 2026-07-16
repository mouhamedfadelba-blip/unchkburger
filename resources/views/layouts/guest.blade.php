```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UNCHK BURGER</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-900">

<div class="min-h-screen flex">

    <!-- Partie Image -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden">

        <img
            src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=1600&q=80"
            class="absolute inset-0 w-full h-full object-cover"
        >

        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/80 via-red-700/70 to-black/80"></div>

        <div class="relative z-10 flex h-full flex-col justify-center items-center text-white px-16">

            <h1 class="text-7xl font-black tracking-wide mb-8">
                🍔 UNCHK
            </h1>

            <h2 class="text-5xl font-bold mb-10">
                BURGER
            </h2>

            <p class="text-center text-xl leading-9 max-w-xl">
                Plateforme intelligente de gestion des commandes,
                des paiements et des livraisons.
            </p>

        </div>

    </div>


    <!-- Partie Formulaire -->

    <div class="flex-1 flex items-center justify-center bg-gray-100 p-8">

        <div class="w-full max-w-md">

            <div class="bg-white rounded-[30px] shadow-2xl p-10">

                <div class="text-center mb-10">

                    <div class="text-5xl mb-4">
                        🍔
                    </div>

                    <h2 class="text-4xl font-extrabold text-orange-600">
                        UNCHK BURGER
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Connectez-vous à votre espace
                    </p>

                </div>

                {{ $slot }}

            </div>

        </div>

    </div>

</div>

</body>
</html>
```
