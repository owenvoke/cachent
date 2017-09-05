<?php

namespace App\Http\Controllers;

use App\Torrent;
use Illuminate\Http\Request;

class TorrentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $torrent = new Torrent();
            $status = $torrent->addFileToDatabase($file);

            if ($status) {
                return view('torrents.show', [
                    'torrent' => $torrent,
                    'file' => $file
                ]);
            }
        }

        return view('errors.upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Torrent $torrent
     * @return \Illuminate\Http\Response
     */
    public function show(Torrent $torrent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Torrent $torrent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Torrent $torrent)
    {
        //
    }
}
