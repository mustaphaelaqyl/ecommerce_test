<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with('product')->where('user_id',$request->user()->id)->get();
        return response()->json(['status'=>'success','data'=>$cart]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1'
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id'=>$request->user()->id,'product_id'=>$validated['product_id']],
            ['quantity'=>$validated['quantity']]
        );

        return response()->json(['status'=>'success','data'=>$cart],201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id',$request->user()->id)->findOrFail($id);
        $validated = $request->validate([
            'quantity'=>'required|integer|min:1'
        ]);
        $cart->update($validated);
        return response()->json(['status'=>'success','data'=>$cart]);
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('user_id',$request->user()->id)->findOrFail($id);
        $cart->delete();
        return response()->json(['status'=>'success','message'=>'Cart item removed']);
    }
}
