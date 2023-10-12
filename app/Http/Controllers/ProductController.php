<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json([
            'data' => $products
        ]);
    }

    public function store(Request $request){
        $data = Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return response()->json([
            'data' => $data
        ], 201);
    }

    public function show($id){
        $data = Product::find($id);
        if(!$data){
            return response()->json([
                'message' => 'No data has found for id '.$id
            ]);
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id){
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return response()->json([
            'data' => $product
        ]);
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
