<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // Extend Laravel's TestCase instead of PHPUnit's TestCase

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderCreation()
    {
        $order = \App\Models\Order::create([
            'customer_name' => 'John Doe',
            'bowling_alleyid' => 1,
            'product' => 'Bowling Ball',
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_name' => 'John Doe',
        ]);
    }

    public function testOrderTotalCalculation()
    {
        // Example test: Ensure the order total is calculated correctly
        $order = \App\Models\Order::factory()->create(); // Use factory to create an order
        $order->addItem(100); // Add an item worth 100
        $order->addItem(50);  // Add an item worth 50

        $this->assertEquals(150, $order->getTotal());
    }

    public function testCreateOrder()
    {
        $orderData = [
            'customer_name' => 'Jane Doe',
            'bowling_alleyid' => 1,
            'product' => 'Bowling Ball',
            'status' => 'pending'
        ];

        $response = $this->post('/orders', $orderData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', $orderData);
    }

    public function testReadOrder()
    {
        $order = \App\Models\Order::create([
            'customer_name' => 'John Doe',
            'bowling_alleyid' => 1,
            'product' => 'Pizza',
            'status' => 'pending'
        ]);

        $response = $this->get("/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertJson($order->toArray());
    }

    public function testUpdateOrder()
    {
        $order = \App\Models\Order::create([
            'customer_name' => 'John Doe',
            'bowling_alleyid' => 1,
            'product' => 'Pizza',
            'status' => 'pending'
        ]);

        $updatedData = [
            'customer_name' => 'Updated Name',
            'bowling_alleyid' => 1,
            'product' => 'Pizza',
            'status' => 'making'
        ];

        $response = $this->put("/orders/{$order->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', $updatedData);
    }

    public function testDeleteOrder()
    {
        $order = \App\Models\Order::create([
            'customer_name' => 'John Doe',
            'bowling_alleyid' => 1,
            'product' => 'Pizza',
            'status' => 'pending'
        ]);

        $response = $this->delete("/orders/{$order->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}