<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('notes index route redirects to login page when not authenticated', function () {
    $response = $this->get('/notes');

    $response->assertRedirect('/login');
});

test('notes index route returns view with events when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Note::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Event',
        'content' => 'Testing Content',
        'tagColor' => 'cyan',
    ]);

    $response = $this->get('/notes');

    $response->assertStatus(200);
});

test('notes store route redirects to login page when not authenticated', function () {
    $response = $this->post('/notes', []);

    $response->assertRedirect('/login');
});

test('notes store route creates note when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/notes', [
        'title' => 'Test Event',
        'content' => 'Testing Content',
        'tagColor' => 'cyan',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('notes', [
        'title' => 'Test Event',
        'content' => 'Testing Content',
        'tagColor' => 'cyan',
        'user_id' => $user->id,
    ]);
});

test('notes update route redirects to login page when not authenticated', function () {
    $note = Note::factory()->create();

    $response = $this->patch("/notes/update/{$note->id}", []);

    $response->assertRedirect('/login');
});

test('notes update route updates note when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $note = Note::factory()->create(['user_id' => $user->id]);

    $response = $this->patch("/notes/update/{$note->id}", [
        'title' => 'Test Event',
        'content' => 'Testing Content',
        'tagColor' => 'cyan',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('notes', [
        'id' => $note->id,
        'title' => 'Test Event',
        'content' => 'Testing Content',
        'tagColor' => 'cyan',
    ]);
});

test('notes destroy route redirects to login page when not authenticated', function () {
    $note = Note::factory()->create();

    $response = $this->delete("/notes/destroy/{$note->id}");

    $response->assertRedirect('/login');
});

test('notes destroy route deletes booking when authenticated', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $note = Note::factory()->create(['user_id' => $user->id]);

    $response = $this->delete("/notes/destroy/{$note->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('notes', ['id' => $note->id]);
});
