<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreOrderRequest;
use App\Http\Requests\Manager\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(OrderService $orderService,PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->getPaginatedOrders(
            $request->only(['status', 'search']),
            15
        );

        $orders->withQueryString();

        return view('manager.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('manager.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception|Throwable
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $validatedData = $request->validated();

            if ($validatedData['status'] === 'payee') {
                $this->paymentService->recordPayment($order, [
                    'amount' => $order->total_amount,
                    'payment_date' => now(),
                ]);
            } else {
                $this->orderService->updateStatus($order, $validatedData['status']);
            }

            return redirect()->route('manager.orders.index')
                ->with('success', 'Le statut de la commande a été mis à jour.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
