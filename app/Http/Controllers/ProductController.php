<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json(['data' => $products]);
    }

    public function store(ProductRequest $request){
        try{
            $data = Product::create($request->validated());
        }catch(ValidationException $e){
            return response()->json($e->errors(), 422);
        }

        return response()->json(['data' => $data], 201);
    }

    public function show($id){
        $data = Product::find($id);
        if(!$data){
            return response()->json(['message' => 'No data has found for id '.$id]);
        }
        return response()->json(['data' => $data]);
    }

    public function update(ProductRequest $request, $id){
        try{
            $product = Product::find($id);
            $product->update($request->validated());
        }catch(ValidationException $e){
            return response()->json($e->errors(), 422);
        }
        return response()->json(['data' => $product]);
    }

    public function destroy($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'No data has found for id '.$id]);
        }
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
