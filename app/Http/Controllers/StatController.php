<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Burger;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // --- Chiffres rapides du jour ---
        $ordersToday = Order::whereDate('created_at', $today)->count();

        $validatedToday = Order::whereDate('created_at', $today)
            ->where('status', 'validated') // adapte selon tes valeurs de statut
            ->count();

        $revenueToday = Order::whereDate('created_at', $today)
            ->where('status', 'validated')
            ->sum('total_amount'); // adapte selon le nom réel de la colonne

        // --- Volume des commandes sur l'année (par mois) ---
        $monthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthLabels = [
            'Jan','Fév','Mar','Avr','Mai','Juin',
            'Juil','Août','Sep','Oct','Nov','Déc'
        ];
        $monthValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthValues[] = $monthly[$m] ?? 0;
        }

        // --- Répartition des burgers par catégorie ---
        $categoriesData = Category::withCount('burgers')->get();

        $stats = [
            'quick' => [
                'orders_today' => $ordersToday,
                'validated_today' => $validatedToday,
                'revenue_today' => $revenueToday,
            ],
            'monthly' => [
                'labels' => $monthLabels,
                'values' => $monthValues,
            ],
            'categories' => [
                'labels' => $categoriesData->pluck('name'),
                'values' => $categoriesData->pluck('burgers_count'),
            ],
        ];

        return view('manager.dashboard', ['stats' => $stats]);
    }
}