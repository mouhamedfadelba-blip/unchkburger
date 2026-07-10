<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Storage;
use Throwable;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected CategoryService $categoryService;

    protected InvoiceService $invoiceService;

    public function __construct(OrderService $orderService, CategoryService $categoryService, InvoiceService $invoiceService)
    {
        $this->orderService = $orderService;
        $this->categoryService = $categoryService;
        $this->invoiceService = $invoiceService;
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(5);
        $latestOrder = $user->orders()->latest()->first();
        $categories = $this->categoryService->getActiveCategoriesWithBurgers();
        return view('customer.orders.index', compact('orders', 'categories', 'latestOrder'));
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
     * @throws Throwable
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated(), Auth::id());
            session()->forget('card');
            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Votre commande a ete enregistree ! Merci de vous presenter au comptoir pour le reglement.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['burgers', 'payment']);
        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @throws Exception
     */
    public function downloadInvoice(Order $order)
    {
        $fileName = "facture-{$order->numero_commande}.pdf";
        $filePath = "invoices/" . $fileName;

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', "La facture physique est introuvable dans le dossier public.");
        }

        return Storage::disk('public')->download($filePath, "Facture_{$order->numero_commande}.pdf");
    }
}
