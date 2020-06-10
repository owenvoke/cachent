<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Route::get('/must-be-confirmed', function () {
        return 'You must be confirmed to see this page.';
    })->middleware(['web', 'password.confirm']);
});

it('requires a user to confirm their password before visiting a protected page', function () {
    $user = factory(User::class)->create();
    $this->be($user);

    $this->get('/must-be-confirmed')
        ->assertRedirect(route('password.confirm'));

    $this->followingRedirects()
        ->get('/must-be-confirmed')
        ->assertSeeLivewire('auth.passwords.confirm');
});

it('requires a user to enter a password to confirm it', function () {
    Livewire::test('auth.passwords.confirm')
        ->call('confirm')
        ->assertHasErrors(['password' => 'required']);
});

it('requires a user to enter their own password to confirm it', function () {
    $user = factory(User::class)->create([
        'password' => Hash::make('password'),
    ]);

    Livewire::test('auth.passwords.confirm')
        ->set('password', 'not-password')
        ->call('confirm')
        ->assertHasErrors(['password' => 'password']);
});

it('redirects a user who correctly confirms their own password', function () {
    $user = factory(User::class)->create([
        'password' => Hash::make('password'),
    ]);

    $this->be($user);

    $this->withSession(['url.intended' => '/must-be-confirmed']);

    Livewire::test('auth.passwords.confirm')
        ->set('password', 'password')
        ->call('confirm')
        ->assertRedirect('/must-be-confirmed');
});
