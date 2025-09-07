<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_save_shop(): void
    {
        $productsAll = Product::factory(3)->create();
        $products = $productsAll->take(2);
        $productsForSave = $products->map(fn(Product $product) => [
            'id' => $product->id,
            'price' => rand(1000, 100000),
        ])->toArray();
        $response = $this->post('/shops', ['name' => 'TestShop', 'products' => $productsForSave]);
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseCount('product_shop', 2);
        $response->assertStatus(302);
    }

    public function test_destroy_shop()
    {
        $shop = Shop::factory(1)->create()->first();
        $products = Product::factory(3)->create();
        $productIds = $products->take(2)->pluck('id')->toArray();
        $shop->products()->sync($productIds);
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseCount('product_shop', 2);
        $response = $this->delete('/shops/'. $shop->id);
        $this->assertDatabaseEmpty('shops');
        $this->assertDatabaseEmpty('product_shop');
        $response->assertStatus(302);
    }

    public function test_update_shop()
    {
        $shop = Shop::factory(1)->create(['name' => 'TestName'])->first();
        $productsAll = Product::factory(3)->create();
        $productsSet = $productsAll->take(2);
        $products = $productsSet->mapWithKeys(fn(Product $product) => [$product->id => ['price' => 300]]);
        $shop->products()->attach($products);
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseCount('product_shop', 2);
        $lastProduct = $productsAll->last();
        $saveProducts = $productsSet->map(fn(Product $product) => [
            'id' => $product->id,
            'price' => 300,
        ])
        ->push(['id' => $lastProduct->id, 'price' => 500])->toArray();
        $response = $this->put('/shops/'. $shop->id, ['name' => 'мвидео', 'products' => $saveProducts]);
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseHas('shops', [
            'name' => 'мвидео',
        ]);
        $this->assertDatabaseCount('product_shop', 3);
        $response->assertStatus(302);
    }

    public function test_detach_all_products()
    {
        $shop = Shop::factory(1)->create(['name' => 'TestName'])->first();
        $productsAll = Product::factory(3)->create();
        $productsSet = $productsAll->take(2);
        $products = $productsSet->mapWithKeys(fn(Product $product) => [$product->id => ['price' => 300]]);
        $shop->products()->attach($products);
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseCount('product_shop', 2);
        $response = $this->put("/shops/$shop->id/detach-all-products");
        $this->assertDatabaseCount('shops', 1);
        $this->assertDatabaseEmpty('product_shop');
        $response->assertStatus(302);
    }
}
