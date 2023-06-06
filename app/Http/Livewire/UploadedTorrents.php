<?php

namespace App\Http\Livewire;

use App\Models\Torrent;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UploadedTorrents extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.uploaded-torrents', [
            'torrents' => auth()->user()
                ->torrents()
                ->paginate(25)
        ]);
    }
}
