<?php

namespace App\Http\Controllers;

use App\Torrent;
use Illuminate\Support\Facades\Storage;

class StatisticController extends Controller
{
    public function index()
    {
        $data = [
            'totalDownloads'           => Torrent::getTotalDownloads(),
            'mostDownloaded'           => Torrent::orderBy('downloads', 'desc')->first(),
            'totalTorrents'            => Torrent::count(),
            'totalTorrentsWithDeleted' => Torrent::withTrashed()->count(),
        ];

        return view('statistics.index', $data);
    }

    /**
     * @param string $hash
     * @return \Illuminate\Http\Response
     */
    public function show(string $hash)
    {
        $torrent = Torrent::where('hash', $hash)->first();

        $storagePath = 'torrents/' . $hash . '.torrent';

        if ($torrent->hash && Storage::exists($storagePath)) {
            $data = [
                'torrent' => $torrent,
                'file'    => new \SplFileInfo(storage_path('app/') . $storagePath)
            ];

            return view('torrents.show', $data);
        } else {
            return response()->json([
                'error' => 'File not found'
            ])->setStatusCode(404);
        }
    }
}
