<?php

namespace App\Http\Controllers;

use App\Torrent;
use Illuminate\Support\Facades\Storage;

/**
 * Class StatisticController
 * @package App\Http\Controllers
 */
class StatisticController extends Controller
{
    /**
     * Display the list of recorded Cachent statistics
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
     * Displays the statistic show page for a specific torrent
     *
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

    /**
     * Destroys all .torrent files from database entries
     * @return \Illuminate\Http\Response
     */
    public function purge()
    {
        $result = Torrent::truncate()->get()->count() == 0;
        if ($result) {
            return response()->json([
                'success' => $result,
                'message' => 'Purge Successful!'
            ])->setStatusCode(200);
        } else {
            return response()->json([
                'error' => 'Cannot Purge Torrents.'
            ])->setStatusCode(500);
        }
    }
}
