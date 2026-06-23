<?php

namespace App\Services;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderCancelledMail;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;
use App\Mail\InvoiceMail;
use Spatie\Permission\Models\Role;

class NotificationService
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function sendOrderConfirmation(Order $order): void
    {
        Mail::to($order->user->email)->send(new OrderConfirmedMail($order));
    }

    /**
     * @throws Exception
     */
    public function sendInvoice(Order $order): void
    {
        $pdfPath = $this->invoiceService->generateInvoice($order);
        Mail::to($order->user->email)->send(new InvoiceMail($order, $pdfPath));
    }

    public function sendCancellationNotice(Order $order): void
    {
        Mail::to($order->user->email)->send(new OrderCancelledMail($order));
    }

    public function notifyAdmin(Order $order): void
    {
        $role = Role::query()->where('name', 'manager')->first();

        if ($role) {
            /** @var User $admin */
            $admin = $role->users()->first();

            if ($admin) {
                $mail = (new NewOrderAdminMail($order, $admin))
                    ->delay(now()->addSeconds(15))
                    ->afterCommit();

                Mail::to($admin->email)->send($mail);
            }
        }
    }
}
