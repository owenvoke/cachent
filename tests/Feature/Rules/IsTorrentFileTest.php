<?php

declare(strict_types=1);

use App\Rules\IsTorrentFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

/** Run the rule the way the upload request does, translation and all. */
function validateTorrent(mixed $value): Illuminate\Validation\Validator
{
    return Validator::make(['torrent' => $value], ['torrent' => new IsTorrentFile]);
}

it('passes a single file torrent', function () {
    expect(validateTorrent(torrentFile())->passes())->toBeTrue();
});

it('passes a multi file torrent', function () {
    expect(validateTorrent(multiFileTorrentFile(['one.bin' => 1000]))->passes())->toBeTrue();
});

it('fails a value that is not an uploaded file', function (mixed $value) {
    $validator = validateTorrent($value);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('torrent'))->toBe('Invalid torrent file provided.');
})->with([
    'a string' => 'example.torrent',
    'null' => null,
    'an array' => [['torrent']],
]);

it('fails a file that is not bencoded', function () {
    $file = UploadedFile::fake()->createWithContent('bad.torrent', 'this is not bencoded');

    expect(validateTorrent($file)->fails())->toBeTrue();
});

it('fails a bencoded file that is not a torrent', function () {
    $file = uploadedTorrent(bencode(['not' => 'a torrent']));

    expect(validateTorrent($file)->fails())->toBeTrue();
});

it('fails an empty file', function () {
    $file = UploadedFile::fake()->createWithContent('empty.torrent', '');

    expect(validateTorrent($file)->fails())->toBeTrue();
});

it('fails a torrent with no v1 info dictionary', function () {
    // The upload pipeline reads the v1 info dictionary, so a v2-only torrent
    // would parse but leave it without a hash or file list.
    expect(validateTorrent(v2OnlyTorrentFile())->fails())->toBeTrue();
});
