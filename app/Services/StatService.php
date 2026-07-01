<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Category_C;
use LaravelIdea\Helper\App\Models\_IH_Order_C;
use App\Models\Burger;

class StatService
{
    public function getQuickStats(): array
    {
        return [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'validated_today' => Order::whereDate('created_at', today())
                ->whereIn('status', ['prete', 'payee'])
                ->count(),
            'revenue_today' => Payment::whereDate('payment_date', today())->sum('amount'),
        ];
    }
    public function getOrdersPerMonth(): array
    {
        $orders = Order::select('id', 'created_at')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->orderBy('created_at')
            ->get();

        $grouped = $orders->groupBy(function ($order) {
            return $order->created_at->translatedFormat('F');
        });

        $labels = [];
        $values = [];

        foreach ($grouped as $month => $items) {
            $labels[] = ucfirst($month);
            $values[] = $items->count();
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
    public function getProductsByCategory(): array
    {
        $data = DB::table('categories')
            ->join('burgers', 'categories.id', '=', 'burgers.category_id')
            ->join('burger_order', 'burgers.id', '=', 'burger_order.burger_id')
            ->select('categories.nom', DB::raw('SUM(burger_order.quantity) as total_qty'))
            ->groupBy('categories.nom')
            ->get();

        return [
            'labels' => $data->pluck('nom')->toArray(),
            'values' => $data->pluck('total_qty')->toArray(),
        ];
    }
    public function getTopSellingBurgers(): Collection
    {
        return DB::table('burger_order')
            ->join('burgers', 'burger_order.burger_id', '=', 'burgers.id')
            ->select('burgers.nom', DB::raw('SUM(burger_order.quantity) as total_sales'))
            ->groupBy('burgers.id', 'burgers.nom')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();
    }
    public function getLatestOrderForUser($userId)
    {
        return Order::where('user_id', $userId)->latest()->first();
    }

    public function getFeaturedBurgers($limit = 4)
    {
        return Burger::where('stock', '>', 0)
            ->where('is_archived', false)
            ->limit($limit)
            ->get();
    }

    public function getTotalSpentByUser($userId)
    {
        return Order::where('user_id', $userId)
            ->where('status', 'payee')
            ->sum('total_amount');
    }

    public function getBurgersEatenCount($userId)
    {
        return DB::table('burger_order')
            ->join('orders', 'burger_order.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('orders.status', '!=', 'annulee')
            ->sum('quantity') ?? 0;
    }
}
