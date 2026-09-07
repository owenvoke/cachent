<?php

declare(strict_types=1);

use App\Models\Torrent;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('torrents'));

it('carries a guest from the dashboard through upload to download', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Click to upload');

    $this->post(route('upload'), ['torrent' => torrentFile()])
        ->assertRedirect(route('details', ['torrent' => sha1(bencode(singleFileInfo()))]));

    $torrent = Torrent::sole();

    $this->get(route('details', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertSee('example.bin')
        ->assertSee('1.00 MB')
        ->assertSee(route('download', ['torrent' => $torrent->hash]));

    $this->get(route('download', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertDownload("{$torrent->hash}.torrent");

    expect($torrent->refresh()->downloads)->toBe(1);
});

it('lists a signed in user their upload straight after making it', function () {
    $user = UserFactory::new()->create();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('You have not uploaded any torrents.');

    $this->actingAs($user)
        ->post(route('upload'), ['torrent' => torrentFile('holiday-photos.bin')])
        ->assertRedirect();

    $torrent = Torrent::sole();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('holiday-photos.bin')
        ->assertSee(route('details', ['torrent' => $torrent->hash]))
        ->assertDontSee('You have not uploaded any torrents.');
});

it('lets a second user re-upload a torrent and download the cached copy', function () {
    $first = UserFactory::new()->create();
    $second = UserFactory::new()->create();

    $this->actingAs($first)->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();
    $stored = Storage::disk('torrents')->get("{$torrent->hash}.torrent");

    $this->actingAs($second)->post(route('upload'), ['torrent' => torrentFile()])
        ->assertRedirect(route('details', ['torrent' => $torrent->hash]));

    // The second upload must not have replaced the cached copy, or the file the
    // hash was computed from could drift away from what is served.
    expect(Torrent::count())->toBe(1)
        ->and(Storage::disk('torrents')->get("{$torrent->hash}.torrent"))->toBe($stored);

    $this->actingAs($second)->get(route('dashboard'))
        ->assertOk()
        ->assertSee(route('details', ['torrent' => $torrent->hash]));

    $response = $this->actingAs($second)
        ->get(route('download', ['torrent' => $torrent->hash]))
        ->assertOk();

    expect($response->streamedContent())->toBe($stored);
});

it('sends a rejected upload back to the dashboard with the torrent uncached', function () {
    $this->from(route('dashboard'))
        ->post(route('upload'), ['torrent' => v2OnlyTorrentFile()])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHasErrors('torrent');

    expect(Torrent::count())->toBe(0);
    Storage::disk('torrents')->assertDirectoryEmpty('');
});
