<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class DownloadController
{
    public function __construct(
        #[Storage('torrents')] private FilesystemAdapter $disk,
        private LoggerInterface $logger,
    ) {}

    public function __invoke(Request $request, Torrent $torrent): StreamedResponse
    {
        $path = "{$torrent->hash}.torrent";

        if (! $this->disk->exists($path)) {
            // A row without its cached file means the disk has drifted from the
            // database, which is worth knowing about even though the visitor
            // only ever sees a missing torrent.
            $this->logger->error('Cached torrent file is missing.', ['hash' => $torrent->hash]);

            throw new NotFoundHttpException;
        }

        $torrent->increment('downloads');

        return $this->disk->download($path);
    }
}
