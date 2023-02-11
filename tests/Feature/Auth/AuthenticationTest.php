<?php

use App\Http\Controllers\Auth\LoginController;

beforeEach(function () {
    $this->user = createUser();
});

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});
test('users can authenticate using the login screen', function () {
    $response = $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);


    $this->assertAuthenticated();
    $response->assertRedirect(LoginController::redirectTo());
});

test('users can not authenticate with invalid password', function () {

    $response = $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
    $response->assertRedirect();
});

test('logout screen can be rendered', function () {
    $response = $this->actingAs($this->user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect();
});



