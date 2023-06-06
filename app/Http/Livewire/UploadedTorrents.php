<?php

namespace App\Http\Livewire;

use App\Models\Torrent;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UploadedTorrents extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.uploaded-torrents', [
            'torrents' => Torrent::query()
                ->where('user_id', )
                ->paginate(25)
        ]);
    }
}
