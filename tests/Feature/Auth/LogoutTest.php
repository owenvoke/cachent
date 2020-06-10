<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

it('allows an authenticated user to log out', function () {
    $user = factory(User::class)->create();
    $this->be($user);

    $this->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertFalse(Auth::check());
});

it('does not allow an unauthenticated user to log out', function () {

    $this->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertFalse(Auth::check());
});
