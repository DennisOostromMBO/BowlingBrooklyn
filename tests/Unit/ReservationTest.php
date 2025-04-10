<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_reservations()
    {
        // Create a person
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01', // Provide a valid date_of_birth
            'is_active' => true, // Provide a valid is_active value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a user
        $user = DB::table('users')->insertGetId([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
            'person_id' => $person, // Provide a valid person_id
            'roll_id' => 1, // Provide a valid roll_id
            'phone' => '1234567890', // Provide a valid phone value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a reservation
        $reservation = DB::table('reservations')->insertGetId([
            'user_id' => $user,
            'ally_number' => 1,
            'number_of_persons' => 4,
            'reservation_date' => now()->addDays(1)->toDateString(),
            'isactive' => true,
            'note' => 'Test reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Fetch reservations
        $response = $this->get(route('reservations.index'));

        // Assert: Check if the reservation is visible
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Test reservation');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_reservation()
    {
        // Create a person
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'date_of_birth' => '1990-01-01', // Provide a valid date_of_birth
            'is_active' => true, // Provide a valid is_active value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a user
        $user = DB::table('users')->insertGetId([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => bcrypt('password'),
            'person_id' => $person, // Provide a valid person_id
            'roll_id' => 1, // Provide a valid roll_id
            'phone' => '1234567890', // Provide a valid phone value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Create a reservation
        $response = $this->post(route('reservations.store'), [
            'user_id' => $user,
            'ally_number' => 2,
            'number_of_persons' => 5,
            'reservation_date' => now()->addDays(2)->toDateString(),
            'note' => 'New reservation',
        ]);

        // Assert: Check if the reservation was created
        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user,
            'ally_number' => 2,
            'number_of_persons' => 5,
            'note' => 'New reservation',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_reservation()
    {
        // Create a person
        $person = DB::table('persons')->insertGetId([
            'first_name' => 'Mike',
            'last_name' => 'Johnson',
            'date_of_birth' => '1990-01-01', // Provide a valid date_of_birth
            'is_active' => true, // Provide a valid is_active value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a user
        $user = DB::table('users')->insertGetId([
            'name' => 'Mike Johnson',
            'email' => 'mikejohnson@example.com',
            'password' => bcrypt('password'),
            'person_id' => $person, // Provide a valid person_id
            'roll_id' => 1, // Provide a valid roll_id
            'phone' => '1234567890', // Provide a valid phone value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a reservation
        $reservation = DB::table('reservations')->insertGetId([
            'user_id' => $user,
            'ally_number' => 3,
            'number_of_persons' => 6,
            'reservation_date' => now()->addDays(3)->toDateString(),
            'isactive' => true,
            'note' => 'Old reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Update the reservation
        $response = $this->put(route('reservations.update', $reservation), [
            'ally_number' => 4,
            'number_of_persons' => 8,
            'reservation_date' => now()->addDays(4)->toDateString(),
            'isactive' => false,
            'note' => 'Updated reservation',
        ]);

        // Assert: Check if the reservation was updated
        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation,
            'ally_number' => 4,
            'number_of_persons' => 8,
            'note' => 'Updated reservation',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_a_reservation()
    {
        // Create a user
        $user = DB::table('users')->insertGetId([
            'name' => 'Lisa Brown',
            'email' => 'lisabrown@example.com',
            'password' => bcrypt('password'),
            'person_id' => 1, // Provide a valid person_id
            'roll_id' => 1, // Provide a valid roll_id
            'phone' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a reservation
        $reservation = DB::table('reservations')->insertGetId([
            'user_id' => $user,
            'ally_number' => 5,
            'number_of_persons' => 3,
            'reservation_date' => now()->addDays(5)->toDateString(),
            'isactive' => true,
            'note' => 'Reservation to delete',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Delete the reservation
        $response = $this->delete(route('reservations.destroy', $reservation));

        // Assert: Check if the reservation was deleted
        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation,
        ]);
    }
}