<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_customers()
    {
        // Arrange: Create a person and customer
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customers')->insert([
            'persons_id' => $person,
            'customer_number' => 'BB0001',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contacts')->insert([
            'customer_id' => DB::table('customers')->where('persons_id', $person)->value('id'),
            'street_name' => 'Main Street',
            'house_number' => '123',
            'addition' => null,
            'postal_code' => '1234AB',
            'city' => 'Amsterdam',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Fetch customers
        $response = $this->get(route('customers.index'));

        // Assert: Check if the customer is visible
        $response->assertStatus(200);
        $response->assertSee('John');
        $response->assertSee('Doe');
        $response->assertSee('BB0001');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_customer()
    {
        // Act: Create a customer
        $response = $this->post(route('customers.store'), [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'date_of_birth' => '1990-01-01',
            'street_name' => 'Main Street',
            'house_number' => '123',
            'postal_code' => '1234AB',
            'city' => 'Amsterdam',
            'phone' => '0612345678',
            'email' => 'janesmith@example.com',
        ]);

        // Assert: Check if the customer was created
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('persons', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
        $this->assertDatabaseHas('customers', [
            'customer_number' => 'BB0001',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_customer()
    {
        // Create a person
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'Mike',
            'last_name' => 'Johnson',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a customer
        $customer = DB::table('customers')->insertGetId([
            'persons_id' => $person,
            'customer_number' => 'BB0002',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Update the customer
        $response = $this->put(route('customers.update', $customer), [
            'first_name' => 'Michael',
            'last_name' => 'Johnson',
            'date_of_birth' => '1990-01-01',
            'street_name' => 'Updated Street',
            'house_number' => '456',
            'postal_code' => '5678CD',
            'city' => 'Rotterdam',
            'phone' => '0612345679',
            'email' => 'michaeljohnson@example.com',
        ]);

        // Assert: Check if the customer was updated
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('persons', [
            'first_name' => 'Michael',
            'last_name' => 'Johnson',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_a_customer()
    {
        // Arrange: Create a person and customer
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'Lisa',
            'last_name' => 'Brown',
            'date_of_birth' => '1990-01-01',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $customer = DB::table('customers')->insertGetId([
            'persons_id' => $person,
            'customer_number' => 'BB0003',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contacts')->insert([
            'customer_id' => $customer,
            'street_name' => 'Main Street',
            'house_number' => '123',
            'addition' => null,
            'postal_code' => '1234AB',
            'city' => 'Amsterdam',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Delete the customer
        $response = $this->delete(route('customers.destroy', $customer));

        // Assert: Check if the customer was deleted
        $response->assertRedirect(route('customers.index')); // Ensure the redirect matches the controller
        $this->assertDatabaseMissing('customers', [
            'id' => $customer,
        ]);
        $this->assertDatabaseMissing('persons', [
            'id' => $person,
        ]);
    }
}
