<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

function actingAs(Authenticatable $user, string $driver = null): TestCase
{
    return test()->actingAs($user, $driver);
}
