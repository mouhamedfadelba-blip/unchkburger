<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use Carbon\Carbon;

class StatController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $ordersToday = Order::whereDate('created_at', $today)->count();

        $validatedToday = Order::whereDate('created_at', $today)
            ->whereIn('status', ['prete', 'payee'])
            ->count();

        $revenueToday = Order::whereDate('created_at', $today)
            ->where('status', 'payee')
            ->sum('total_amount');

        $monthly = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthLabels = ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];
        $monthValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthValues[] = $monthly[$m] ?? 0;
        }

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
                'labels' => $categoriesData->pluck('nom'),
                'values' => $categoriesData->pluck('burgers_count'),
            ],
        ];

        return view('manager.dashboard', ['stats' => $stats]);
    }
}