<?php

declare(strict_types=1);

use App\Models\Torrent;
use Database\Factories\TorrentFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('torrents'));

/** Put a torrent on the disk the same way the upload pipeline would. */
function storedTorrent(string $contents = 'd8:announce0:e'): Torrent
{
    $torrent = TorrentFactory::new()->create(['downloads' => 0]);

    Storage::disk('torrents')->put("{$torrent->hash}.torrent", $contents);

    return $torrent;
}

it('serves the stored file under the torrent hash', function () {
    $torrent = storedTorrent('the-original-bytes');

    $response = $this->get(route('download', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertDownload("{$torrent->hash}.torrent");

    expect($response->streamedContent())->toBe('the-original-bytes');
});

it('counts every download', function () {
    $torrent = storedTorrent();

    foreach (range(1, 3) as $expected) {
        $this->get(route('download', ['torrent' => $torrent->hash]))->assertOk();

        expect($torrent->refresh()->downloads)->toBe($expected);
    }
});

it('is reachable by a guest', function () {
    $torrent = storedTorrent();

    $this->get(route('download', ['torrent' => $torrent->hash]))->assertOk();
});

it('returns a 404 for a hash that was never uploaded', function () {
    $this->get(route('download', ['torrent' => str_repeat('a', 40)]))->assertNotFound();

    Storage::disk('torrents')->assertDirectoryEmpty('');
});

it('returns a 404 when the row outlived its cached file', function () {
    $torrent = TorrentFactory::new()->create(['downloads' => 0]);

    $this->get(route('download', ['torrent' => $torrent->hash]))->assertNotFound();
});

it('does not count a download it could not serve', function () {
    $torrent = TorrentFactory::new()->create(['downloads' => 7]);

    $this->get(route('download', ['torrent' => $torrent->hash]))->assertNotFound();

    expect($torrent->refresh()->downloads)->toBe(7);
});

it('logs the hash whose cached file has gone missing', function () {
    Log::spy();

    $torrent = TorrentFactory::new()->create();

    $this->get(route('download', ['torrent' => $torrent->hash]))->assertNotFound();

    Log::shouldHaveReceived('error')
        ->once()
        ->with('Cached torrent file is missing.', ['hash' => $torrent->hash]);
});

it('does not log when the torrent is served normally', function () {
    Log::spy();

    $torrent = storedTorrent();

    $this->get(route('download', ['torrent' => $torrent->hash]))->assertOk();

    Log::shouldNotHaveReceived('error');
});
