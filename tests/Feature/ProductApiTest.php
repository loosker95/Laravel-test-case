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

    private Product $product;

    public function setUp():void{
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    public function test_product_api_get_data_successfully(){
        $response = $this->getJson(route('product.index'));

        $response->assertOk();
        $response->assertSuccessful();
        $response->assertJsonFragment([
            'name' => $this->product->name,
            'price' => $this->product->price,
        ]);
        $response->assertJsonCount(1, 'data');
    }

    public function test_api_product_store_successflly(){
        $data = [
            'name' => $this->product->name,
            'price' => $this->product->price,
        ];
        $response = $this->postJson(route('product.create'), $data);

        $response->assertCreated();
        $response->assertSuccessful();
        $response->assertJson(['data'=> $data]);
        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function test_get_one_product_by_id_successfully(){
        $response = $this->getJson(route('product.show', $this->product->id));

        $response->assertOk();
        $response->assertJsonPath('data.name', $this->product->name);
        $response->assertJsonPath('data.price', $this->product->price);
        // $response->assertJsonMissingPath()
        $response->assertJsonStructure([
            "data" => [
                "id",
                "name",
                "price",
            ]
        ]);
    }

    public function test_get_one_product_by_id_show_exption(){
        $response = $this->getJson(route('product.show', ['id'=> 888]));
        $response->assertStatus(422);
        $this->assertEquals('Id not found', $response['message']);
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
        // $this->markTestSkipped('can add custom messge');
        $response = $this->deleteJson(route('product.delete', $this->product->id));
        $response->assertOk();
        $response->assertJsonMissing($this->product->toArray());
        $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
    }
}
