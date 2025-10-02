<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Customer: create order from cart
    public function store(Request $request)
    {
        $order = $this->orderService->createOrderFromCart($request->user());
        return response()->json(['status'=>'success','data'=>$order],201);
    }

    // Customer: list orders
    public function index(Request $request)
    {
        $orders = Order::with('payments','carts.product')->where('user_id',$request->user()->id)->get();
        return response()->json(['status'=>'success','data'=>$orders]);
    }

    // Admin: update order status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'status'=>'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);
        $order->update(['status'=>$validated['status']]);
        return response()->json(['status'=>'success','data'=>$order]);
    }
}
