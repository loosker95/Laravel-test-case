<?php

namespace App\services;

use App\Models\Product;
use Exception;

class ProductService
{
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
