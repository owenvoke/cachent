<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Torrent;
use Arokettu\Torrent\TorrentFile;
use Arokettu\Torrent\TorrentFile\V1\Info;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use RuntimeException;

readonly class UploadController
{
    public function __construct(
        private Redirector $redirector,
    ) {}

    public function __invoke(UploadRequest $request): RedirectResponse
    {
        /** @var UploadedFile $torrentFile */
        $torrentFile = $request->file('torrent');

        $data = TorrentFile::load($torrentFile->getRealPath());

        // IsTorrentFile rejects torrents without a v1 info dictionary, so this
        // only guards against the rule and the controller drifting apart.
        $info = $data->v1() ?? throw new RuntimeException('Torrent is missing a v1 info dictionary.');

        $torrent = Torrent::firstOrCreate([
            'hash' => $info->getInfoHash(),
        ], [
            'filename' => $data->getDisplayName(),
            'size' => $this->totalSize($info),
        ]);

        if ($user = $request->user()) {
            $user->torrents()->syncWithoutDetaching($torrent);
        }

        if ($torrent->wasRecentlyCreated) {
            $torrentFile->storePubliclyAs('', "{$torrent->hash}.torrent", 'torrents');
        }

        return $this->redirector->route('details', ['torrent' => $torrent->hash]);
    }

    /** Sum the declared length of every file the torrent describes. */
    private function totalSize(Info $info): int
    {
        $size = 0;

        foreach ($info->getFiles() as $file) {
            $size += $file->length;
        }

        return $size;
    }
}
