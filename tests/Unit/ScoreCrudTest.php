<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScoreCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with hardcoded data
        $this->seed(); // This will run the DatabaseSeeder
    }

    public function test_it_can_show_scores()
    {
        // Create a reservation linked to a seeded user
        \DB::table('reservations')->insert([
            'user_id' => 1,
            'ally_number' => 1,
            'number_of_persons' => 4,
            'isactive' => true,
            'note' => 'Test reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a score linked to the reservation
        \DB::table('scores')->insert([
            'reservation_id' => \DB::table('reservations')->where('note', 'Test reservation')->value('id'),
            'points' => 200,
            'round' => 1,
            'status' => 'In progress',
            'isactive' => true,
            'team_name' => 'Strikers',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Fetch scores
        $response = $this->get(route('scores.index'));

        // Assert: Check if the score is visible
        $response->assertStatus(200);
        $response->assertSee('Strikers');
        $response->assertSee('200');
    }

    public function test_it_can_create_a_score()
    {
        // Create a reservation linked to a seeded user
        \DB::table('reservations')->insert([
            'user_id' => 1,
            'ally_number' => 1,
            'number_of_persons' => 4,
            'isactive' => true,
            'note' => 'Test reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Create a score
        $response = $this->post(route('scores.store'), [
            'reservation_id' => \DB::table('reservations')->where('note', 'Test reservation')->value('id'),
            'points' => 250,
            'round' => 1,
            'status' => 'In progress',
            'isactive' => true,
            'team_name' => 'Pin Pals',
        ]);

        // Assert: Check if the score was created
        $response->assertRedirect(route('scores.index'));
        $this->assertDatabaseHas('scores', [
            'reservation_id' => \DB::table('reservations')->where('note', 'Test reservation')->value('id'),
            'points' => 250,
            'team_name' => 'Pin Pals',
        ]);
    }

    public function test_it_can_update_a_score()
    {
        // Create a reservation linked to a seeded user
        \DB::table('reservations')->insert([
            'user_id' => 1,
            'ally_number' => 1,
            'number_of_persons' => 4,
            'isactive' => true,
            'note' => 'Test reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a score
        \DB::table('scores')->insert([
            'reservation_id' => \DB::table('reservations')->where('note', 'Test reservation')->value('id'),
            'points' => 200,
            'round' => 1,
            'status' => 'In progress',
            'isactive' => true,
            'team_name' => 'Strikers',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Update the score
        $response = $this->put(route('scores.update', [
            'team_name' => 'Strikers', // Use team_name to identify the score
        ]), [
            'team_name' => 'Updated Team',
            'points' => 300,
            'round' => 2,
            'status' => 'Confirmed',
            'isactive' => false,
        ]);

        // Assert: Check if the score was updated
        $response->assertRedirect(route('scores.index'));
        $this->assertDatabaseHas('scores', [
            'points' => 300,
            'team_name' => 'Updated Team',
            'status' => 'Confirmed',
        ]);
    }

    public function test_it_can_delete_a_score()
    {
        // Create a reservation linked to a seeded user
        \DB::table('reservations')->insert([
            'user_id' => 1,
            'ally_number' => 1,
            'number_of_persons' => 4,
            'isactive' => true,
            'note' => 'Test reservation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create a score
        \DB::table('scores')->insert([
            'reservation_id' => \DB::table('reservations')->where('note', 'Test reservation')->value('id'),
            'points' => 200,
            'round' => 1,
            'status' => 'In progress',
            'isactive' => true,
            'team_name' => 'Strikers',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Act: Delete the score
        $response = $this->delete(route('scores.destroy', [
            'team_name' => 'Strikers', // Use team_name to identify the score
        ]));

        // Assert: Check if the score was deleted
        $response->assertRedirect(route('scores.index'));
        $this->assertDatabaseMissing('scores', [
            'team_name' => 'Strikers',
        ]);
    }
}
