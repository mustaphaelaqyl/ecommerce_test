<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filters
        if($request->has('category')){
            $query->where('category_id',$request->category);
        }
        if($request->has('min_price')){
            $query->where('price','>=',$request->min_price);
        }
        if($request->has('max_price')){
            $query->where('price','<=',$request->max_price);
        }
        if($request->has('q')){
            $query->where('name','like','%'.$request->q.'%');
        }

        return response()->json(['status'=>'success','data'=>$query->get()]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['status'=>'success','data'=>$product]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'category_id'=>'required|exists:categories,id'
        ]);

        $product = Product::create($validated);
        return response()->json(['status'=>'success','data'=>$product],201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'sometimes|required|numeric',
            'stock'=>'sometimes|required|integer',
            'category_id'=>'sometimes|required|exists:categories,id'
        ]);

        $product->update($validated);
        return response()->json(['status'=>'success','data'=>$product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['status'=>'success','message'=>'Product deleted']);
    }
}
