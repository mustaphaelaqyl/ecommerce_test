<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class CartOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_customer_can_place_order_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'stock' => 10,
            'price' => 100
        ]);

        // Authenticate as user using Sanctum
        $this->actingAs($user, 'sanctum');

        // Add product to cart
        $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 2
        ])->assertStatus(201);

        // Place order
        $this->postJson('/api/orders')->assertStatus(201);

        // Verify order created in DB
        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);

        // Verify stock reduced
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8
        ]);
    }
}
