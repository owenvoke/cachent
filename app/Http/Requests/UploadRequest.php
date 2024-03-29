<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\IsTorrentFile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'torrent' => ['required', 'file', 'mimes:torrent', new IsTorrentFile()],
        ];
    }
}
