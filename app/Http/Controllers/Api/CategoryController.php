<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(['status'=>'success','data'=>Category::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string'
        ]);

        $category = Category::create($validated);
        return response()->json(['status'=>'success','data'=>$category],201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string'
        ]);

        $category->update($validated);
        return response()->json(['status'=>'success','data'=>$category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['status'=>'success','message'=>'Category deleted']);
    }
}
