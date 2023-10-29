<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Exceptions\IdNotFoundException;
use App\Http\Resources\ProductResource;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(): ProductResource{

        $products = Product::all();
        return ProductResource::make($products);
        // return ProductResource::collection($products);
        // return new ProductResource($products);
    }

    public function store(ProductRequest $request){
        try{
            $data = Product::create($request->validated());
        }catch(ValidationException $e){
            return response()->json($e->errors(), 422);
        }

        return response()->json(['data' => $data], 201);
    }

    public function show(ProductService $productService, $id){
        try{
            $data = $productService->getOneById($id);
        }catch(IdNotFoundException $e){
            return response()->json(['message' => $e->getMessage()], 422);
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
