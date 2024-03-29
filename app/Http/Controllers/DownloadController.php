<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class DownloadController
{
    public function __construct(
        private ResponseFactory $response,
        private Application $app,
    ) {
    }

    public function __invoke(Request $request, Torrent $torrent): BinaryFileResponse
    {
        $torrent->increment('downloads');

        return $this->response->download(
            $this->app->storagePath("app/torrents/{$torrent->hash}.torrent"),
            "{$torrent->hash}.torrent"
        );
    }
}
