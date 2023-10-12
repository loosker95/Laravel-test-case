<?php

use App\Models\User;


beforeEach(fn () => $this->user = $user = User::factory()->create());

test('has home page', function () {
    $response = $this->get('/');
    // $response->assertStatus(200);
    expect($response->status())->toBe(200);
});

describe('Login tests', function () {
    test('Login work perfectly', function () {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        // $response->assertStatus(302);
        expect($response->status())->toBe(302);
        $response->assertRedirect('dashboard');
    });

    test('Email required validation while login', function () {
        // $this->withoutExceptionHandling();
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertInvalid([
            'email' => 'The email field is required',
        ]);
    });
});
