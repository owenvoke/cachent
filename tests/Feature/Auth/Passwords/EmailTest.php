<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can view the password request page', function () {
    $this->get(route('password.request'))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.passwords.email');
});

it('requires a user to enter an email', function () {
    Livewire::test('auth.passwords.email')
        ->call('sendResetPasswordLink')
        ->assertHasErrors(['email' => 'required']);
});

it('requires a user to enter a valid email', function () {
    Livewire::test('auth.passwords.email')
        ->set('email', 'email')
        ->call('sendResetPasswordLink')
        ->assertHasErrors(['email' => 'email']);
});

it('sends an email to a user that enters a valid email', function () {
    $user = factory(User::class)->create();

    Livewire::test('auth.passwords.email')
        ->set('email', $user->email)
        ->call('sendResetPasswordLink')
        ->assertNotSet('emailSentMessage', false);

    $this->assertDatabaseHas('password_resets', [
        'email' => $user->email,
    ]);
});
