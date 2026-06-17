<x-customer-layout>
    <div class="mb-8 border-b border-gray-200 pb-5">
        <h1 class="text-2xl font-semibold text-gray-900">
            Bonjour, {{ Auth::user()->name }}
        </h1>
        <p class="text-sm text-gray-500 mt-1">Gérez vos commandes et consultez l'historique de votre compte.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Section: Commande en cours -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Commande en cours
            </h2>

            @if($latestOrder && in_array($latestOrder->status, ['en_attente', 'en_preparation', 'prete']))
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-gray-100">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Commande N° {{ $latestOrder->numero_commande }}</span>
                            <h3 class="text-lg font-medium text-gray-900 mt-1">
                                @if($latestOrder->status == 'en_attente')
                                    En attente de confirmation
                                @elseif($latestOrder->status == 'en_preparation')
                                    En cours de préparation
                                @else
                                    Prête pour le retrait
                                @endif
                            </h3>
                        </div>
                        <div class="bg-amber-50 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1.5">
                            <div class="w-2 h-2 rounded-full {{ $latestOrder->status == 'prete' ? 'bg-green-500' : 'bg-amber-500 animate-pulse' }}"></div>
                            <span class="text-amber-700 text-sm font-medium capitalize">{{ str_replace('_', ' ', $latestOrder->status) }}</span>
                        </div>
                    </div>

                    <div class="mt-6 relative">
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 transition-all duration-500 ease-out"
                                 style="width: {{ $latestOrder->status == 'en_attente' ? '33' : ($latestOrder->status == 'en_preparation' ? '66' : '100') }}%">
                            </div>
                        </div>
                        <div class="flex justify-between mt-3 text-xs font-medium text-gray-500">
                            <span class="{{ $latestOrder->status == 'en_attente' ? 'text-amber-600 font-semibold' : '' }}">Validée</span>
                            <span class="{{ $latestOrder->status == 'en_preparation' ? 'text-amber-600 font-semibold' : '' }}">En cuisine</span>
                            <span class="{{ $latestOrder->status == 'prete' ? 'text-amber-600 font-semibold' : '' }}">Prête</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">Aucune commande active</h3>
                    <p class="mt-1 text-sm text-gray-500">Vous n'avez pas de commande en cours pour le moment.</p>
                    <div class="mt-6">
                        <a href="/catalogue" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            Nouvelle commande
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Section: Mon Compte -->
        <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Résumé du compte
            </h2>
            
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Total des dépenses</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ number_format($totalSpent ?? 0, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <dt class="text-sm text-gray-500">Articles commandés</dt>
                        <dd class="text-sm font-semibold text-gray-900">{{ $burgersCount ?? 0 }}</dd>
                    </div>
                </dl>
                <div class="mt-6">
                    <a href="{{ route('customer.orders.index') ?? '#' }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 flex items-center justify-center gap-1 group">
                        Voir l'historique complet
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-customer-layout>