<?php

declare(strict_types=1);

namespace App\Rules;

use Arokettu\Bencode\Exceptions\BencodeException;
use Arokettu\Torrent\Exception\TorrentFileException;
use Arokettu\Torrent\TorrentFile;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;

class IsTorrentFile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('Invalid torrent file provided.')->translate();

            return;
        }

        try {
            $torrent = TorrentFile::load($value->getRealPath());
        } catch (BencodeException|TorrentFileException) {
            $fail('Invalid torrent file provided.')->translate();

            return;
        }

        // The upload pipeline reads the v1 info dictionary, so a v2-only
        // torrent would parse but leave us without a hash or file list.
        if ($torrent->v1() === null) {
            $fail('Invalid torrent file provided.')->translate();
        }
    }
}
