<?php

use App\Models\Score;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// User Story 1: As a bowling alley staff member, I want to create a new score record
test('staff can create a new score record', function () {
    $user = User::factory()->create();

    $reservation = Reservation::factory()->create();

    $scoreData = [
        'reservation_id' => $reservation->id,
        'points' => 245,
        'round' => 1,
        'status' => 'In progress',
        'isactive' => true,
        'team_name' => 'Strikers'
    ];

    $response = $this->actingAs($user)
                     ->post('/scores', $scoreData);

    // Assuming the controller redirects after successful creation
    $response->assertStatus(302);

    // Check that the score was added to the database
    $this->assertDatabaseHas('scores', [
        'reservation_id' => $reservation->id,
        'points' => 245
    ]);
});

// User Story 2: As a bowling alley staff member, I want to view a score record
test('staff can view an existing score record', function () {
    $user = User::factory()->create();

    $score = Score::factory()->create([
        'points' => 198,
        'team_name' => 'Pin Pals',
        'status' => 'Confirmed'
    ]);

    $response = $this->actingAs($user)
                     ->get("/scores/{$score->id}");

    $response->assertStatus(200);

    // If your view displays these values, you can assert they appear
    // Otherwise, use an appropriate assertion for your response format
    $response->assertSee('198');
    $response->assertSee('Pin Pals');
    $response->assertSee('Confirmed');
});

// User Story 3: As a bowling alley staff member, I want to update a score record
test('staff can update a score record', function () {
    $user = User::factory()->create();

    $score = Score::factory()->create([
        'points' => 150,
        'status' => 'In progress'
    ]);

    $updatedData = [
        'points' => 280,
        'status' => 'Confirmed'
    ];

    $response = $this->actingAs($user)
                     ->put("/scores/{$score->id}", $updatedData);

    // Assuming the controller redirects after successful update
    $response->assertStatus(302);

    // Check that the database has the updated data
    $this->assertDatabaseHas('scores', [
        'id' => $score->id,
        'points' => 280,
        'status' => 'Confirmed'
    ]);
});

// User Story 4: As a bowling alley staff member, I want to delete a score record
test('staff can delete a score record', function () {
    $user = User::factory()->create();

    $score = Score::factory()->create();

    // Verify the score exists in the database
    $this->assertDatabaseHas('scores', [
        'id' => $score->id
    ]);

    $response = $this->actingAs($user)
                     ->delete("/scores/{$score->id}");

    // Assuming the controller redirects after successful deletion
    $response->assertStatus(302);

    // Check that the score was removed from the database
    $this->assertDatabaseMissing('scores', [
        'id' => $score->id
    ]);
});
