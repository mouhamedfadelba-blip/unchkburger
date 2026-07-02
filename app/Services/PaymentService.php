<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;

class PaymentService
{
    /**
     * @throws Throwable
     */
    public function recordPayment(Order $order, array $data)
    {
        if ($order->payment()->exists() || $order->status === 'payee') {
            throw new Exception("Cette commande a deja ete reglee.");
        }

        if ($order->status === 'annulee') {
            throw new Exception("Impossible de payer une commande annulee.");
        }

        return DB::transaction(function () use ($order, $data) {
            $payment = Payment::create([
                'order_id'       => $order->id,
                'amount'        => $data['amount'],
                'payment_date'  => $data['payment_date'] ?? now(),
            ]);

            $order->update(['status' => 'payee']);

            return $payment;
        });
    }
    public function getDailyRevenue()
    {
        return Payment::whereDate('payment_date', today())->sum('amount');
    }
}
