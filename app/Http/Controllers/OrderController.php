<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Burger;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['user', 'items.burger'])->get();
    }

    public function store(OrderRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {

            $total = 0;

            $order = Order::create([
                'user_id' => $validated['user_id'],
                'status' => 'en_attente',
                'reference' => 'CMD-' . time(),
                'total_amount' => 0,
            ]);

            foreach ($validated['items'] as $item) {

                $burger = Burger::findOrFail($item['burger_id']);

                if ($burger->stock < $item['quantity']) {
                    return response()->json([
                        'message' => "Stock insuffisant pour {$burger->name}"
                    ], 400);
                }

                $subtotal = $burger->price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'burger_id' => $burger->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $burger->price,
                ]);

                $burger->decrement('stock', $item['quantity']);
            }

                $order->update([
                'total_amount' => $total
]);

            DB::commit();

            return response()->json([
                'message' => 'Commande créée avec succès.',
                'data' => $order->load('items.burger')
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(Order $order)
    {
        return $order->load(['user', 'items.burger']);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return response()->json([
            'message' => 'Commande modifiée avec succès.',
            'data' => $order
        ]);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => 'Commande supprimée avec succès.'
        ]);
    }
}