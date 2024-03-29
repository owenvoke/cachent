<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Torrent;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

readonly class DetailsController
{
    public function __construct(
        private ViewFactory $view,
    ) {
    }

    public function __invoke(Request $request, Torrent $torrent): View
    {
        return $this->view->make('details', ['torrent' => $torrent]);
    }
}
