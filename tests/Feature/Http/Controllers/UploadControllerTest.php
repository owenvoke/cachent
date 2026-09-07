<?php

declare(strict_types=1);

use App\Models\Torrent;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Build a bencoded torrent so the tests exercise the real parser rather than a stub.
 *
 * @param  array<string, mixed>  $data
 */
function bencode(array|int|string $data): string
{
    if (is_int($data)) {
        return "i{$data}e";
    }

    if (is_string($data)) {
        return strlen($data).':'.$data;
    }

    if (array_is_list($data)) {
        return 'l'.implode('', array_map('bencode', $data)).'e';
    }

    ksort($data);

    $encoded = 'd';

    foreach ($data as $key => $value) {
        $encoded .= bencode((string) $key).bencode($value);
    }

    return $encoded.'e';
}

function torrentFile(string $name = 'example.bin', int $length = 1048576): UploadedFile
{
    $contents = bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => [
            'length' => $length,
            'name' => $name,
            'piece length' => 262144,
            'pieces' => str_repeat("\x01", 20),
        ],
    ]);

    $path = tempnam(sys_get_temp_dir(), 'torrent').'.torrent';
    file_put_contents($path, $contents);

    return new UploadedFile($path, $name.'.torrent', 'application/x-bittorrent', test: true);
}

beforeEach(fn () => Storage::fake('torrents'));

it('stores an uploaded torrent and redirects to its details page', function () {
    $response = $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    expect($torrent->hash)->toHaveLength(40)
        ->and($torrent->filename)->toBe('example.bin')
        ->and($torrent->size)->toBe(1048576);

    $response->assertRedirect(route('details', ['torrent' => $torrent->hash]));
    Storage::disk('torrents')->assertExists("{$torrent->hash}.torrent");
});

it('computes the same info hash the details route is keyed by', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    // The hash is the standard SHA-1 of the bencoded info dictionary, so it must
    // stay stable: existing rows and /torrents/{hash} URLs depend on it.
    $info = bencode([
        'length' => 1048576,
        'name' => 'example.bin',
        'piece length' => 262144,
        'pieces' => str_repeat("\x01", 20),
    ]);

    expect($torrent->hash)->toBe(sha1($info));

    $this->get(route('details', ['torrent' => $torrent->hash]))->assertOk();
});

it('deduplicates a torrent that was already uploaded', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    expect(Torrent::count())->toBe(1);
});

it('attaches the torrent to the uploader when signed in', function () {
    $user = UserFactory::new()->create();

    $this->actingAs($user)->post(route('upload'), ['torrent' => torrentFile()]);
    $this->actingAs($user)->post(route('upload'), ['torrent' => torrentFile()]);

    expect($user->torrents()->count())->toBe(1);
});

it('rejects a file that is not a torrent', function () {
    $response = $this->post(route('upload'), [
        'torrent' => UploadedFile::fake()->createWithContent('bad.torrent', 'this is not bencoded'),
    ]);

    $response->assertSessionHasErrors('torrent');
    expect(Torrent::count())->toBe(0);
});

it('serves the stored torrent for download and counts it', function () {
    $this->post(route('upload'), ['torrent' => torrentFile()]);

    $torrent = Torrent::sole();

    $this->get(route('download', ['torrent' => $torrent->hash]))
        ->assertOk()
        ->assertDownload("{$torrent->hash}.torrent");

    expect($torrent->refresh()->downloads)->toBe(1);
});
