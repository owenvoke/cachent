<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can view verification page', function () {
    $user = factory(User::class)->create([
        'email_verified_at' => null,
    ]);

    Auth::login($user);

    $this->get(route('verification.notice'))
        ->assertSuccessful()
        ->assertSeeLivewire('auth.verify');
});

it('can resend the verification email', function () {
    $user = factory(User::class)->create();

    Livewire::actingAs($user);

    Livewire::test('auth.verify')
        ->call('resend')
        ->assertEmitted('resent');
});

it('can verify an email', function () {
    $user = factory(User::class)->create([
        'email_verified_at' => null,
    ]);

    Auth::login($user);

    $url = URL::temporarySignedRoute('verification.verify',
        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

    $this->get($url)
        ->assertRedirect(route('home'));

    $this->assertTrue($user->hasVerifiedEmail());
});
