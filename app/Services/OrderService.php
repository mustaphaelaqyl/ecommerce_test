<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    // Calculate total including discount and tax
    public function calculateTotal(Collection $cartItems): float
    {
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        // Example discount: 5% if subtotal > 200
        $discount = $subtotal > 200 ? $subtotal * 0.05 : 0;
        $tax = $subtotal * 0.10; // 10% tax example

        return round($subtotal - $discount + $tax, 2);
    }

    // Create order from user's cart
    public function createOrderFromCart(User $user)
    {
        $cartItems = $user->carts()->with('product')->get();
        $total = $this->calculateTotal($cartItems);

        return DB::transaction(function() use ($user, $cartItems, $total) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Reduce product stock
            foreach ($cartItems as $item) {
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear user's cart
            $user->carts()->delete();

            return $order;
        });
    }
}
