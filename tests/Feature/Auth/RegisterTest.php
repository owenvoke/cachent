<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('checks the registration page contains Livewire component', function () {
    $this->get(route('register'))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.register');
});

it('redirects if the user is already logged in', function () {
    $user = factory(User::class)->create();

    $this->be($user);

    $this->get(route('register'))
        ->assertRedirect(route('home'));
});

it('allows a user to register', function () {
    Livewire::test('auth.register')
        ->set('name', 'Tall Stack')
        ->set('email', 'tallstack@example.com')
        ->set('password', 'password')
        ->set('passwordConfirmation', 'password')
        ->call('register')
        ->assertRedirect(route('home'));

    $this->assertTrue(User::whereEmail('tallstack@example.com')->exists());
    $this->assertEquals('tallstack@example.com', Auth::user()->email);
});


it('requires a name', function () {
    Livewire::test('auth.register')
        ->set('name', '')
        ->call('register')
        ->assertHasErrors(['email' => 'required']);
});

it('requires an email', function () {
    Livewire::test('auth.register')
        ->set('email', '')
        ->call('register')
        ->assertHasErrors(['email' => 'required']);
});


it('requires a valid email', function () {
    Livewire::test('auth.register')
        ->set('email', 'tallstack')
        ->call('register')
        ->assertHasErrors(['email' => 'email']);
});


it('requires an email that has not already been taken', function () {
    factory(User::class)->create(['email' => 'tallstack@example.com']);

    Livewire::test('auth.register')
        ->set('email', 'tallstack@example.com')
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});

it('shows an email has already been taken message as the user types', function () {
    factory(User::class)->create(['email' => 'tallstack@example.com']);

    Livewire::test('auth.register')
        ->set('email', 'smallstack@gmail.com')
        ->assertHasNoErrors()
        ->set('email', 'tallstack@example.com')
        ->call('register')
        ->assertHasErrors(['email' => 'unique']);
});


it('requires a password', function () {
    Livewire::test('auth.register')
        ->set('password', '')
        ->set('passwordConfirmation', 'password')
        ->call('register')
        ->assertHasErrors(['password' => 'required']);
});


it('requires a password that is at least the minimum length', function () {
    Livewire::test('auth.register')
        ->set('password', 'secret')
        ->set('passwordConfirmation', 'secret')
        ->call('register')
        ->assertHasErrors(['password' => 'min']);
});


it('requires a password that matches the password configuration', function () {
    Livewire::test('auth.register')
        ->set('email', 'tallstack@example.com')
        ->set('password', 'password')
        ->set('passwordConfirmation', 'not-password')
        ->call('register')
        ->assertHasErrors(['password' => 'same']);
});
