<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController
{
    public function __construct(
        private readonly ViewFactory $view,
    ) {
    }

    public function __invoke(Request $request): View
    {
        return $this->view->make('dashboard');
    }
}
