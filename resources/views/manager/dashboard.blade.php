<x-manager-layout>
    <x-slot name="header">Tableau de Bord Analytics</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Commandes en cours</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['quick']['orders_today'] ?? 0 }}</p>
                </div>
                <span class="bg-orange-100 p-2 rounded-lg text-2xl">⏳</span>
            </div>
            <p class="text-xs text-slate-400 mt-4 italic">Total pour la journée d'aujourd'hui</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Commandes Validées</p>
                    <p class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['quick']['validated_today'] ?? 0 }}</p>
                </div>
                <span class="bg-emerald-100 p-2 rounded-lg text-2xl">✅</span>
            </div>
            <p class="text-xs text-slate-400 mt-4 italic">Prêtes ou déjà récupérées</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-indigo-100 bg-gradient-to-br from-white to-indigo-50/30">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-indigo-600 uppercase tracking-wider">Recettes du jour</p>
                    <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($stats['quick']['revenue_today'] ?? 0, 2, ',', ' ') }} FCFA</p>
                </div>
                <span class="bg-indigo-600 p-2 rounded-lg text-2xl">💰</span>
            </div>
            <p class="text-xs text-indigo-400 mt-4 font-medium">Chiffre d'affaires encaissé</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span>📈</span> Volume des commandes (Annuel)
            </h3>
            <canvas id="ordersChart" height="250"></canvas>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span>🍱</span> Répartition par catégorie
            </h3>
            <canvas id="categoryChart" height="250"></canvas>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctxOrders = document.getElementById('ordersChart').getContext('2d');
            new Chart(ctxOrders, {
                type: 'line',
                data: {
                    labels: {!! json_encode($stats['monthly']['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Nombre de commandes',
                        data: {!! json_encode($stats['monthly']['values'] ?? []) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });

            const ctxCat = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCat, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($stats['categories']['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Nombre de produits',
                        data: {!! json_encode($stats['categories']['values'] ?? []) !!},
                        backgroundColor: ['#f97316', '#4f46e5', '#10b981', '#f59e0b', '#6366f1'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    @endpush
</x-manager-layout>