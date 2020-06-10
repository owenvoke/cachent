<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can view the login page', function () {
    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.login');
});

it('is redirected if already logged in', function () {
    $user = factory(User::class)->create();

    $this->be($user);

    $this->get(route('login'))
        ->assertRedirect(route('home'));
});

it('allows a user to log in', function () {
    $user = factory(User::class)->create(['password' => Hash::make('password')]);

    Livewire::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');

    $this->assertAuthenticatedAs($user);
});

it('redirects to the homepage after logging in', function () {
    $user = factory(User::class)->create(['password' => Hash::make('password')]);

    Livewire::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertRedirect(route('home'));
});

it('requires an email address', function () {
    $user = factory(User::class)->create(['password' => Hash::make('password')]);

    Livewire::test('auth.login')
        ->set('password', 'password')
        ->call('authenticate')
        ->assertHasErrors(['email' => 'required']);
});

it('requires a valid email address', function () {
    $user = factory(User::class)->create(['password' => Hash::make('password')]);

    Livewire::test('auth.login')
        ->set('email', 'invalid-email')
        ->set('password', 'password')
        ->call('authenticate')
        ->assertHasErrors(['email' => 'email']);
});

it('requires a valid password', function () {
    $user = factory(User::class)->create(['password' => Hash::make('password')]);

    Livewire::test('auth.login')
        ->set('email', $user->email)
        ->call('authenticate')
        ->assertHasErrors(['password' => 'required']);
});

it('shows a message on a bad login attempt', function () {
    $user = factory(User::class)->create();

    Livewire::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'bad-password')
        ->call('authenticate')
        ->assertHasErrors('email');

    $this->assertFalse(Auth::check());
});
