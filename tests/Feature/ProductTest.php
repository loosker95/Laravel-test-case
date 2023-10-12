<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use App\Models\Product;
use App\services\ProductService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_created_and_return_product(): void
    {
        $products = (new ProductService())->create('product one', 2000);
        $this->assertInstanceOf(Product::class, $products);
    }

    public function test_product_create_validation_exeption()
    {
        try{
            (new ProductService())->create('product one', 12000);
        }catch(\Exception $e){
            $this->assertInstanceOf(Exception::class, $e);
        }
    }


}
