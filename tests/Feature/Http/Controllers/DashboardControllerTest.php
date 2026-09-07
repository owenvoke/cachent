<?php

declare(strict_types=1);

use Database\Factories\TorrentFactory;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;

it('shows the upload form to a guest', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Click to upload')
        ->assertSee(route('upload'));
});

it('does not show the torrent list to a guest', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee('You have not uploaded any torrents.');
});

it('shows a signed in user their uploaded torrents', function () {
    $user = UserFactory::new()->create();
    $torrent = TorrentFactory::new()->create(['filename' => 'example.bin']);
    $user->torrents()->attach($torrent);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('example.bin')
        ->assertSee(route('details', ['torrent' => $torrent->hash]));
});

it('tells a signed in user when they have uploaded nothing', function () {
    $this->actingAs(UserFactory::new()->create())
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('You have not uploaded any torrents.');
});

it('reports why an upload was rejected', function () {
    $this->from(route('dashboard'))
        ->post(route('upload'), [
            'torrent' => UploadedFile::fake()->createWithContent('bad.torrent', 'this is not bencoded'),
        ])
        ->assertRedirect(route('dashboard'));

    $this->followingRedirects()
        ->from(route('dashboard'))
        ->post(route('upload'), [
            'torrent' => UploadedFile::fake()->createWithContent('bad.torrent', 'this is not bencoded'),
        ])
        ->assertOk()
        ->assertSee('That torrent could not be uploaded')
        ->assertSee('Invalid torrent file provided.');
});
