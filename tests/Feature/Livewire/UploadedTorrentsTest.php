<?php

declare(strict_types=1);

use App\Livewire\UploadedTorrents;
use Database\Factories\TorrentFactory;
use Database\Factories\UserFactory;
use Livewire\Livewire;

it('can render the component', function () {
    $user = UserFactory::new()->create();

    $component = Livewire::actingAs($user)->test(UploadedTorrents::class);

    $component->assertStatus(200);
});

it('lists the torrents the user has uploaded', function () {
    $user = UserFactory::new()->create();
    $torrent = TorrentFactory::new()->create(['filename' => 'example.bin']);
    $user->torrents()->attach($torrent);

    Livewire::actingAs($user)->test(UploadedTorrents::class)
        ->assertSee('example.bin')
        ->assertSee(route('details', ['torrent' => $torrent->hash]));
});

it('falls back to the hash for a torrent with no filename', function () {
    $user = UserFactory::new()->create();
    $torrent = TorrentFactory::new()->create(['filename' => null]);
    $user->torrents()->attach($torrent);

    Livewire::actingAs($user)->test(UploadedTorrents::class)
        ->assertSee($torrent->hash);
});

it('does not leak torrents uploaded by somebody else', function () {
    $user = UserFactory::new()->create();
    $other = UserFactory::new()->create();

    $other->torrents()->attach(TorrentFactory::new()->create(['filename' => 'theirs.bin']));

    Livewire::actingAs($user)->test(UploadedTorrents::class)
        ->assertDontSee('theirs.bin')
        ->assertSee('You have not uploaded any torrents.');
});

it('paginates at twenty five torrents a page', function () {
    $user = UserFactory::new()->create();

    $torrents = TorrentFactory::new()
        ->count(26)
        ->sequence(fn ($sequence) => ['filename' => "torrent-{$sequence->index}.bin"])
        ->create();

    $user->torrents()->attach($torrents);

    $component = Livewire::actingAs($user)->test(UploadedTorrents::class)
        ->assertSee('torrent-0.bin')
        ->assertDontSee('torrent-25.bin');

    $component->call('gotoPage', 2)
        ->assertSee('torrent-25.bin')
        ->assertDontSee('torrent-0.bin');
});
