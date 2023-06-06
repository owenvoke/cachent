<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class DownloadController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly Application $app,
    ) {
    }

    public function __invoke(Request $request, Torrent $torrent)
    {
        $torrent->increment('downloads');

        return $this->response->download(
            $this->app->storagePath("app/torrents/{$torrent->hash}.torrent"),
            "{$torrent->hash}.torrent"
        );
    }
}
