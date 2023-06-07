<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Torrent;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;

readonly class UploadController
{
    public function __construct(
        private Redirector $redirector,
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

        if ($user = $request->user()) {
            $user->torrents()->syncWithoutDetaching($torrent);
        }

        if ($torrent->wasRecentlyCreated) {
            $torrentFile->storePubliclyAs('torrents', "{$torrent->hash}.torrent");
        }

        return $this->redirector->route('details', ['torrent' => $torrent->hash]);
    }
}
