<?php

declare(strict_types=1);

use App\Http\Livewire\UploadedTorrents;
use Database\Factories\UserFactory;
use Livewire\Livewire;

it('can render the component', function () {
    $user = UserFactory::new()->create();

    $component = Livewire::actingAs($user)->test(UploadedTorrents::class);

    $component->assertStatus(200);
});
