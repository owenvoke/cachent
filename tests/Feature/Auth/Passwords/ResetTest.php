<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can view the password reset page', function () {
    $user = factory(User::class)->create();

    $token = Str::random(16);

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => Carbon::now(),
    ]);

    $this->get(route('password.reset', [
        'email' => $user->email,
        'token' => $token,
    ]))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.passwords.reset');
});

it('can reset a users password', function () {
    $user = factory(User::class)->create();

    $token = Str::random(16);

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => Carbon::now(),
    ]);

    Livewire::test('auth.passwords.reset', [
        'token' => $token,
    ])
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('passwordConfirmation', 'new-password')
        ->call('resetPassword');

    $this->assertTrue(Auth::attempt([
        'email' => $user->email,
        'password' => 'new-password',
    ]));
});

it('requires a token', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => null,
    ])
        ->call('resetPassword')
        ->assertHasErrors(['token' => 'required']);
});

it('requires an email', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => Str::random(16),
    ])
        ->set('email', null)
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'required']);
});

it('requires a valid email', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => Str::random(16),
    ])
        ->set('email', 'email')
        ->call('resetPassword')
        ->assertHasErrors(['email' => 'email']);
});

it('requires a password', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => Str::random(16),
    ])
        ->set('password', '')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'required']);
});

it('requires a password that is at least the minimum length', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => Str::random(16),
    ])
        ->set('password', 'secret')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'min']);
});

it('requires the password confirmation to match the password', function () {
    Livewire::test('auth.passwords.reset', [
        'token' => Str::random(16),
    ])
        ->set('password', 'new-password')
        ->set('passwordConfirmation', 'not-new-password')
        ->call('resetPassword')
        ->assertHasErrors(['password' => 'same']);
});
