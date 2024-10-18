<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(ProductsTableSeeder::class);
    }

    public function test_successful_order_creation()
    {
        $response = $this->postJson('/api/order', [
            'product_id' => 1,
            'quantity' => 2,
        ], [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'You have successfully ordered this product.']);

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'available_stock' => 8, // 10 - 2
        ]);
    }

    public function test_unsuccessful_order_due_to_insufficient_stock()
    {
        $response = $this->postJson('/api/order', [
            'product_id' => 2,
            'quantity' => 9999,
        ], [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
        ]);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Failed to order this product due to unavailability of the stock']);
    }

    protected function getAccessToken()
    {
        // Simulate getting a valid access token, implement your logic here
        return 'your_access_token_here';
    }
}
