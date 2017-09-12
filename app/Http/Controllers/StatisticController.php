<?php

namespace App\Http\Controllers;

use App\Torrent;

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
}
