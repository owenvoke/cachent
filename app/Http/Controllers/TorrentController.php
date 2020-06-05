<?php

namespace App\Http\Controllers;

use App\Torrent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class TorrentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'torrents' => Torrent::withTrashed()
                ->where('hash', 'LIKE', '%' . $request->get('hash') . '%')
                ->paginate(50)
        ];

        return view('torrents.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            /** @var Torrent $torrent */
            $torrent = new Torrent();
            $status = $torrent->addFileToDatabase($file);

            if ($status) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'hash' => $torrent->hash,
                        'updated_at' => time(),
                        'direct_link' => route('torrents.show', ['torrent' => $torrent]),
                    ])->setStatusCode(201);
                }

                return view('torrents.show', [
                    'torrent' => $torrent,
                    'file' => $file
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'error' => __('validation.uploaded', ['attribute' => 'torrent']),
            ])->setStatusCode(500);
        }

        return view('errors.upload');
    }

    /**
     * Display the specified resource.
     *
     * @param Torrent $torrent
     * @return \Illuminate\Http\JsonResponse|object|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(Torrent $torrent)
    {
        $storagePath = 'torrents/' . $torrent->hash . '.torrent';

        if (!$torrent->trashed() && Storage::exists($storagePath)) {
            $torrent->downloads++;
            $torrent->save();
            return response()->download(storage_path('app/') . $storagePath);
        }

        return response()->json([
            'error' => 'File not found'
        ])->setStatusCode(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Torrent  $torrent
     * @return \Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function destroy(Torrent $torrent)
    {
        return response()->json([
            'success' => $torrent->delete(),
        ])->setStatusCode(200);
    }
}
