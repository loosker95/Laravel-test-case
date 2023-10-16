<?php

namespace App\services;

use Exception;
use App\Models\Product;
use App\Exceptions\IdNotFoundException;

class ProductService
{

    public function getOneById($id){
        $data = Product::find($id);

        if(!$data){
            // throw new IdNotFoundException('Id not found', 422);
            throw IdNotFoundException::notFount('Id not found', 422);
        }
        return $data;
    }

    public function create($name, $price)
    {
        if($price > 10000){
            throw new Exception('Price too much..');
        }

        $product = Product::create([
            'name' => $name,
            'price' => $price
        ]);

        return $product;
    }
}
