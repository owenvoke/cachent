<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class DownloadController
{
    public function __construct(
        private FilesystemFactory $filesystem,
    ) {}

    public function __invoke(Request $request, Torrent $torrent): StreamedResponse
    {
        $torrent->increment('downloads');

        // Read through the same disk the upload wrote to, so the two cannot
        // drift apart the way a hardcoded storage path did.
        return $this->filesystem->disk('torrents')
            ->download("{$torrent->hash}.torrent");
    }
}
