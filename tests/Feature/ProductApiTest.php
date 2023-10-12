<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;


    public function test_product_api_get_data_successfully(){
        $products = Product::factory()->create();
        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertSuccessful();
        $response->assertJsonFragment([
            'name' => $products->name,
            'price' => $products->price,
        ]);
        $response->assertJsonCount(1, 'data');
    }

    public function test_api_product_store_successflly(){
        $post = Product::factory()->create();
        $data = [
            'name' => $post->name,
            'price' => $post->price,
        ];
        $response = $this->postJson(route('product.create'), $data);

        $response->assertCreated();
        $response->assertSuccessful();
        $response->assertJson(['data'=> $data]);
        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function test_get_one_product_by_id_successfully(){

        $post = Product::factory()->create();
        $response = $this->getJson(route('product.show', $post->id));

        $response->assertOk();
        $response->assertJsonPath('data.name', $post->name);
        $response->assertJsonPath('data.price', $post->price);
        // $response->assertJsonMissingPath()
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "price",
            ]
        ]);
    }

    public function test_product_has_been_updated_successfully(){
        $product = [
            'name' => 'name',
            'price' => 100
        ];
        $updateProduct = Product::create($product);
        $response = $this->putJson(route('product.update', $updateProduct->id), [
            'name' => 'Update name',
            'price' => 2000
        ]);
        $response->assertOk();
        $response->assertJsonMissing($product);
        $this->assertDatabaseMissing('products', ['id' => $product['name']]);
    }

    public function test_product_can_be_deleted_succesfully(){
        $product = Product::factory()->create();
        $response = $this->deleteJson(route('product.delete', $product->id));
        $response->assertOk();
        $response->assertJsonMissing($product->toArray());
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
