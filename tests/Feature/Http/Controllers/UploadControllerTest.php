<?php

declare(strict_types=1);

use App\Models\Torrent;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('torrents'));

it('stores an uploaded torrent and redirects to its details page', function () {
    $response = $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    expect($torrent->hash)->toHaveLength(40)
        ->and($torrent->filename)->toBe('example.bin')
        ->and($torrent->size)->toBe(1048576)
        ->and($torrent->downloads)->toBe(0);

    $response->assertRedirect(route('details', ['torrent' => $torrent->hash]));
    Storage::disk('torrents')->assertExists("{$torrent->hash}.torrent");
});

it('stores the torrent bytes verbatim so the download is byte for byte identical', function () {
    $contents = bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => singleFileInfo(),
    ]);

    $this->post(route('upload'), ['torrent' => uploadedTorrent($contents)]);

    $torrent = Torrent::sole();

    expect(Storage::disk('torrents')->get("{$torrent->hash}.torrent"))->toBe($contents);
});

it('computes the same info hash the details route is keyed by', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    // The hash is the standard SHA-1 of the bencoded info dictionary, so it must
    // stay stable: existing rows and /torrents/{hash} URLs depend on it.
    expect($torrent->hash)->toBe(sha1(bencode(singleFileInfo())));

    $this->get(route('details', ['torrent' => $torrent->hash]))->assertOk();
});

it('sums the declared length of every file in a multi file torrent', function () {
    $this->post(route('upload'), [
        'torrent' => multiFileTorrentFile(['one.bin' => 1000, 'nested/two.bin' => 2500]),
    ]);

    $torrent = Torrent::sole();

    expect($torrent->size)->toBe(3500)
        ->and($torrent->filename)->toBe('example-dir');
});

it('treats torrents with different contents as separate uploads', function () {
    $this->post(route('upload'), ['torrent' => torrentFile('first.bin')]);
    $this->post(route('upload'), ['torrent' => torrentFile('second.bin')]);

    expect(Torrent::count())->toBe(2)
        ->and(Torrent::pluck('filename')->all())->toBe(['first.bin', 'second.bin']);
});

it('deduplicates a torrent that was already uploaded', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    expect(Torrent::count())->toBe(1);
});

it('keeps the download counter of a torrent that is uploaded again', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();
    $this->get(route('download', ['torrent' => $torrent->hash]));

    $this->post(route('upload'), ['torrent' => torrentFile()])
        ->assertRedirect(route('details', ['torrent' => $torrent->hash]));

    expect($torrent->refresh()->downloads)->toBe(1);
});

it('attaches the torrent to the uploader when signed in', function () {
    $user = UserFactory::new()->create();

    $this->actingAs($user)->post(route('upload'), ['torrent' => torrentFile()]);
    $this->actingAs($user)->post(route('upload'), ['torrent' => torrentFile()]);

    expect($user->torrents()->count())->toBe(1);
});

it('attaches an existing torrent to a second uploader', function () {
    $first = UserFactory::new()->create();
    $second = UserFactory::new()->create();

    $this->actingAs($first)->post(route('upload'), ['torrent' => torrentFile()]);
    $this->actingAs($second)->post(route('upload'), ['torrent' => torrentFile()]);

    expect(Torrent::count())->toBe(1)
        ->and($first->torrents()->count())->toBe(1)
        ->and($second->torrents()->count())->toBe(1);
});

it('accepts an upload from a guest without attaching it to anybody', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()])->assertRedirect();

    expect(Torrent::sole()->users()->count())->toBe(0);
});

it('requires a torrent to be provided', function () {
    $this->post(route('upload'))->assertSessionHasErrors('torrent');

    expect(Torrent::count())->toBe(0);
});

it('rejects a file that is not a torrent', function () {
    $response = $this->post(route('upload'), [
        'torrent' => UploadedFile::fake()->createWithContent('bad.torrent', 'this is not bencoded'),
    ]);

    $response->assertSessionHasErrors('torrent');
    expect(Torrent::count())->toBe(0);
});

it('rejects a torrent without a v1 info dictionary', function () {
    $this->post(route('upload'), ['torrent' => v2OnlyTorrentFile()])
        ->assertSessionHasErrors('torrent');

    expect(Torrent::count())->toBe(0);
    Storage::disk('torrents')->assertDirectoryEmpty('');
});

it('accepts a torrent whatever filename it was uploaded under', function () {
    $contents = bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => singleFileInfo(),
    ]);

    // `mimes:torrent` reads the contents rather than trusting the client, so a
    // mislabelled but otherwise valid torrent still gets through.
    $path = tempnam(sys_get_temp_dir(), 'torrent').'.txt';
    file_put_contents($path, $contents);

    $this->post(route('upload'), [
        'torrent' => new UploadedFile($path, 'example.txt', 'text/plain', test: true),
    ])->assertSessionHasNoErrors();

    expect(Torrent::sole()->hash)->toBe(sha1(bencode(singleFileInfo())));
});

it('serves the stored torrent for download and counts it', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    $this->get(route('download', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertDownload("{$torrent->hash}.torrent");

    expect($torrent->refresh()->downloads)->toBe(1);
});
