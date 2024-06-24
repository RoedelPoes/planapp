<?php

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('todo index route redirects to login page when not authenticated', function () {
    $response = $this->get('/todo');

    $response->assertRedirect('/login');
});

test('todo index route returns view with events when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Todo::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Event',
        'date' => '2024-07-04 00:00:00',
        'completed' => '0',
        'tagColor' => 'cyan',
    ]);

    $response = $this->get('/todo');

    $response->assertStatus(200);
});

test('todo store route redirects to login page when not authenticated', function () {
    $response = $this->post('/todo', []);

    $response->assertRedirect('/login');
});

test('todo store route creates todo when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/todo', [
        'title' => 'Test Event',
        'date' => '2024-07-04 00:00:00',
        'tagColor' => 'cyan',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('todos', [
        'title' => 'Test Event',
        'date' => '2024-07-04 00:00:00',
        'completed' => 0,
        'tagColor' => 'cyan',
        'user_id' => $user->id,
    ]);

    $todo = Todo::find($response->content());
    $this->assertNotNull($todo);
});

test('todo update route redirects to login page when not authenticated', function () {
    $todo = Todo::factory()->create();

    $response = $this->patch("/todo/complete/{$todo->id}", []);

    $response->assertRedirect('/login');
});

test('todo update route updates todo when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $todo = Todo::factory()->create(['user_id' => $user->id]);

    $response = $this->patch("/todo/complete/{$todo->id}", [
        'completed' => '1'
    ]);

    //$response->assertStatus(200);
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'completed' => '1',
    ]);
});

test('todo destroy route redirects to login page when not authenticated', function () {
    $todo = Todo::factory()->create();

    $response = $this->delete("/todo/destroy/{$todo->id}");

    $response->assertRedirect('/login');
});

test('todo destroy route deletes todo when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $todo = Todo::factory()->create(['user_id' => $user->id]);

    $response = $this->delete("/todo/destroy/{$todo->id}");

    //$response->assertStatus(200);
    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});
