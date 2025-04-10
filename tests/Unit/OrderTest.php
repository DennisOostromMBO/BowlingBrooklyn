<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Person;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_orders()
    {
        // Create an order
        $order = Order::create([
            'bowling_alleyid' => 1,
            'product' => 'Pizza', // Use a valid ENUM value
            'status' => 'pending',
            'note' => 'Test order',
        ]);

        // Act: Fetch orders
        $response = $this->get(route('orders.index'));

        // Assert: Check if the order is visible
        $response->assertStatus(200);
        $response->assertSee('Pizza');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_an_order()
    {
        // Act: Create an order
        $response = $this->post(route('orders.store'), [
            'bowling_alleyid' => 1,
            'product' => 'Nachos', // Use a valid ENUM value
            'status' => 'pending',
            'note' => 'Test order',
        ]);

        // Assert: Check if the order was created
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', [
            'bowling_alleyid' => 1,
            'product' => 'Nachos',
            'status' => 'pending',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_an_order()
    {
        // Create an order
        $order = Order::create([
            'bowling_alleyid' => 1,
            'product' => 'Burger', // Use a valid ENUM value
            'status' => 'pending',
            'note' => 'Test order',
        ]);

        // Act: Update the order
        $response = $this->put(route('orders.update', $order->id), [
            'bowling_alleyid' => 1,
            'product' => 'VIP Package', // Use a valid ENUM value
            'status' => 'pending',
            'note' => 'Updated order',
        ]);

        // Assert: Check if the order was updated
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'product' => 'VIP Package',
            'status' => 'pending',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_an_order()
    {
        // Create an order
        $order = Order::create([
            'bowling_alleyid' => 1,
            'product' => 'Burger', // Use a valid ENUM value
            'status' => 'pending',
            'note' => 'Test order',
        ]);

        // Act: Delete the order
        $response = $this->delete(route('orders.destroy', $order->id));

        // Assert: Check if the order was deleted
        $response->assertRedirect(route('orders.index'));
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function testOrderCreation()
    {
        // Create a person
        $person = Person::create([
            'first_name' => 'John',
            'infix' => null,
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
        ]);

        // Create a customer linked to the person
        $customer = Customer::create([
            'persons_id' => $person->id,
            'customer_number' => 'CUST123',
            'is_active' => true,
        ]);

        // Create an order linked to the customer
        $order = Order::create([
            'bowling_alleyid' => 1,
            'product' => 'Burger',
            'status' => 'pending',
            'note' => 'Test order',
        ]);

        // Assert the order exists in the database
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'product' => 'Burger',
        ]);

        
    }
}