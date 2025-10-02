<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Store a payment for an order (mock)
     */
    public function store(Request $r, $id)
    {
        $order = Order::findOrFail($id);

        // Accept amount from request or default to full order total
        $amount = $r->input('amount', $order->total_amount);

        // Simulate payment gateway: 95% success rate
        $success = rand(0, 100) > 5;

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'status' => $success ? 'success' : 'failed',
            'gateway_reference' => $success ? 'MOCKREF' . Str::random(8) : null
        ]);

        if ($success) {
            // Update order status to confirmed
            $order->update(['status' => 'confirmed']);
        }

        return response()->json([
            'status' => $success ? 'success' : 'error',
            'data' => ['payment' => $payment]
        ], $success ? 200 : 402);
    }

    /**
     * Show a specific payment
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => ['payment' => $payment]
        ]);
    }
}
