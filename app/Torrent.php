<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $hash
 * @property string deleted_at
 * @property string created_at
 * @property string updated_at
 */
class Torrent extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $status = false;

    public function addFileToDatabase(UploadedFile $file)
    {
        if ($file->extension() === 'torrent') {
            $torrent = new \Torrent($file->getRealPath());
            $this->hash = $torrent->hash_info();

            if ($this->hash) {
                if (!Storage::exists('torrents/' . $this->hash . '.torrent')) {
                    $this->status = $file->storeAs('torrents', $this->hash . '.torrent');

                    $torrentInstance = new Torrent();
                    $torrentInstance->where('hash', $this->hash)->get();
                    if (!$torrentInstance) {
                        return $this->save();
                    }
                }

                $this->status = true;
            }
        }

        return $this->status;
    }
}
