<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Torrent;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;

class UploadController
{
    public function __construct(
        private readonly Redirector $redirector,
        private readonly Filesystem $filesystem,
    ) {
    }

    public function __invoke(UploadRequest $request): RedirectResponse
    {
        /** @var UploadedFile $torrentFile */
        $torrentFile = $request->file('torrent');

        $data = new \Torrent($torrentFile);

        $torrent = Torrent::firstOrCreate([
            'hash' => $data->hash_info(),
        ], [
            'filename' => $data->name(),
            'size' => $data->size(),
        ]);

        if ($request->user()) {
            $request->user()->torrents()->attach($torrent);
        }

        if ($torrent->wasRecentlyCreated && ! $this->filesystem->exists("app/torrents/{$torrent->hash}.torrent")) {
            $torrentFile->storePubliclyAs('torrents', "{$torrent->hash}.torrent");
        }

        return $this->redirector->route('details', ['torrent' => $torrent->hash]);
    }
}
