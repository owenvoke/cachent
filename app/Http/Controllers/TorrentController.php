<?php

namespace App\Http\Controllers;

use App\Torrent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class TorrentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'torrents' => Torrent::withTrashed()
                ->where('hash', 'LIKE', '%' . Input::get('hash') . '%')
                ->paginate(50)
        ];

        return view('torrents.index', $data);
    }

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
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'hash' => $torrent->hash,
                        'updated_at' => time(),
                        'direct_link' => route('torrents.show', ['torrent' => $torrent->hash]),
                    ])->setStatusCode(201);
                } else {
                    return view('torrents.show', [
                        'torrent' => $torrent,
                        'file' => $file
                    ]);
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'error' => __('validation.uploaded', ['attribute' => 'torrent']),
            ])->setStatusCode(500);
        } else {
            return view('errors.upload');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $hash
     * @return \Illuminate\Http\Response
     */
    public function show(string $hash)
    {
        $torrent = new Torrent();
        $torrent->where('hash', $hash)->get();

        $storagePath = 'torrents/' . $hash . '.torrent';

        if (!$torrent->trashed() && Storage::exists($storagePath)) {
            return response()->download(storage_path('app/') . $storagePath);
        }

        return response()->json([
            'error' => 'File not found'
        ])->setStatusCode(404);
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
