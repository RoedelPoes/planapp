<?php

use App\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('calendar index route redirects to login page when not authenticated', function () {
    $response = $this->get('/calendar');

    $response->assertRedirect('/login');
});

test('calendar index route returns view with events when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Booking::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Event',
        'start_date' => '2024-06-20 10:00:00',
        'end_date' => '2024-06-20 12:00:00',
        'color' => '#000000',
    ]);

    $response = $this->get('/calendar');

    $response->assertStatus(200);
    $response->assertViewHas('events');
});

test('calendar store route redirects to login page when not authenticated', function () {
    $response = $this->post('/calendar', []);

    $response->assertRedirect('/login');
});

test('calendar store route creates booking when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/calendar', [
        'title' => 'Test Event',
        'start_date' => '2024-06-20 10:00:00',
        'end_date' => '2024-06-20 12:00:00',
        'color' => '#000000',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('bookings', [
        'title' => 'Test Event',
        'start_date' => '2024-06-20 10:00:00',
        'end_date' => '2024-06-20 12:00:00',
        'color' => '#000000',
        'user_id' => $user->id,
    ]);
});

test('calendar update route redirects to login page when not authenticated', function () {
    $booking = Booking::factory()->create();

    $response = $this->patch("/calendar/update/{$booking->id}", []);

    $response->assertRedirect('/login');
});

test('calendar update route updates booking when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $booking = Booking::factory()->create(['user_id' => $user->id]);

    $response = $this->patch("/calendar/update/{$booking->id}", [
        'title' => 'Updated Event',
        'start_date' => '2024-06-21 10:00:00',
        'end_date' => '2024-06-21 12:00:00',
        'color' => '#000000',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'title' => 'Updated Event',
        'start_date' => '2024-06-21 10:00:00',
        'end_date' => '2024-06-21 12:00:00',
        'color' => '#000000',
    ]);
});

test('calendar destroy route redirects to login page when not authenticated', function () {
    $booking = Booking::factory()->create();

    $response = $this->delete("/calendar/destroy/{$booking->id}");

    $response->assertRedirect('/login');
});

test('calendar destroy route deletes booking when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $booking = Booking::factory()->create(['user_id' => $user->id]);

    $response = $this->delete("/calendar/destroy/{$booking->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
});



