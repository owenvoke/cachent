<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;

class DetailsController
{
    public function __construct(
        private readonly ViewFactory $view,
    ) {
    }

    public function __invoke(Request $request, Torrent $torrent)
    {
        return $this->view->make('details', ['torrent' => $torrent]);
    }
}
