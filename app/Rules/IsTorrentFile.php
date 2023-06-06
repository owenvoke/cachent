<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Translation\PotentiallyTranslatedString;
use Torrent;

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

        if (! Torrent::is_torrent($value->getRealPath())) {
            $fail('Invalid torrent file provided.')->translate();
        }
    }
}
