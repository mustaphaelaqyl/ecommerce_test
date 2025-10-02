<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStockAvailable{
    public function handle(Request $req, Closure $next){
        $insufficient = $req->user()->carts()->with('product')->get()
            ->filter(fn($item)=> $item->quantity > $item->product->stock);
        if($insufficient->isNotEmpty()){
            return response()->json([
                'message'=>'Some items do not have enough stock',
                'items'=>$insufficient->map(fn($i)=>[
                    'product_id'=>$i->product_id,
                    'requested'=>$i->quantity,
                    'available'=>$i->product->stock
                ])
            ],422);
        }
        return $next($req);
    }
}