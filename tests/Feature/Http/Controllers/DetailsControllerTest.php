<?php

declare(strict_types=1);

use Database\Factories\TorrentFactory;

it('shows everything the details page promises about a torrent', function () {
    $torrent = TorrentFactory::new()->create([
        'filename' => 'example.bin',
        'size' => 1048576,
        'downloads' => 1234,
    ]);

    $this->get(route('details', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertSee($torrent->hash)
        ->assertSee('example.bin')
        ->assertSee('1.00 MB')
        ->assertSee('1,234')
        ->assertSee(route('download', ['torrent' => $torrent->hash]));
});

it('falls back to the hash when the original filename is unknown', function () {
    $torrent = TorrentFactory::new()->create(['filename' => null]);

    $this->get(route('details', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertSee('Unknown')
        ->assertSee($torrent->hash);
});

it('is reachable by a guest', function () {
    $torrent = TorrentFactory::new()->create();

    $this->get(route('details', ['torrent' => $torrent->hash]))->assertOk();
});

it('looks a torrent up by its hash rather than its id', function () {
    $torrent = TorrentFactory::new()->create();

    $this->get("/torrents/{$torrent->id}")->assertNotFound();
    $this->get("/torrents/{$torrent->hash}")->assertOk();
});

it('returns a 404 for a hash that was never uploaded', function () {
    $this->get(route('details', ['torrent' => str_repeat('a', 40)]))->assertNotFound();
});
