<?php

use App\Models\User;

test('home route redirects to login page when not authenticated', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

test('home route redirects to homepage page when authenticated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
});
