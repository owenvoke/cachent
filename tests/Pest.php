<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Bencode a value so the tests exercise the real torrent parser rather than a stub.
 *
 * @param  array<array-key, mixed>|int|string  $data
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

/**
 * Wrap already bencoded contents in an uploaded `.torrent` file.
 */
function uploadedTorrent(string $contents, string $filename = 'example.torrent'): UploadedFile
{
    $path = tempnam(sys_get_temp_dir(), 'torrent').'.torrent';
    file_put_contents($path, $contents);

    return new UploadedFile($path, $filename, 'application/x-bittorrent', test: true);
}

/**
 * A single file v1 torrent, the shape the upload pipeline is built around.
 */
function torrentFile(string $name = 'example.bin', int $length = 1048576): UploadedFile
{
    return uploadedTorrent(bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => singleFileInfo($name, $length),
    ]), $name.'.torrent');
}

/**
 * The info dictionary `torrentFile()` builds, so tests can hash it themselves.
 *
 * @return array<string, mixed>
 */
function singleFileInfo(string $name = 'example.bin', int $length = 1048576): array
{
    return [
        'length' => $length,
        'name' => $name,
        'piece length' => 262144,
        'pieces' => str_repeat("\x01", 20),
    ];
}

/**
 * A v1 torrent describing a directory, where the size is the sum of its files.
 *
 * @param  array<string, int>  $files  Relative path to declared length.
 */
function multiFileTorrentFile(array $files, string $name = 'example-dir'): UploadedFile
{
    $entries = [];

    foreach ($files as $path => $length) {
        $entries[] = ['length' => $length, 'path' => explode('/', $path)];
    }

    return uploadedTorrent(bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => [
            'files' => $entries,
            'name' => $name,
            'piece length' => 262144,
            'pieces' => str_repeat("\x01", 20),
        ],
    ]), $name.'.torrent');
}

/**
 * A torrent that parses but carries no v1 info dictionary, leaving the upload
 * pipeline without the hash and file list it reads.
 */
function v2OnlyTorrentFile(string $name = 'example.bin', int $length = 1048576): UploadedFile
{
    return uploadedTorrent(bencode([
        'announce' => 'http://tracker.example.test/announce',
        'info' => [
            'file tree' => [
                $name => ['' => ['length' => $length, 'pieces root' => str_repeat("\x02", 32)]],
            ],
            'meta version' => 2,
            'name' => $name,
            'piece length' => 262144,
        ],
        'piece layers' => [],
    ]), $name.'.torrent');
}
