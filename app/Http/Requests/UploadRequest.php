<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\IsTorrentFile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'torrent' => ['file', 'mimes:torrent', new IsTorrentFile()],
        ];
    }
}
