<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        return Payment::with('order')->get();
    }

    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        return response()->json([
            'message' => 'Paiement enregistré avec succès.',
            'data' => $payment
        ], 201);
    }

    public function show(Payment $payment)
    {
        return $payment->load('order');
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return response()->json([
            'message' => 'Paiement modifié avec succès.',
            'data' => $payment
        ]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Paiement supprimé avec succès.'
        ]);
    }
}