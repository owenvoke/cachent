<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UploadController;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** @var Router $router */
$router->get('/', DashboardController::class)->name('dashboard');
$router->post('/upload', UploadController::class)->name('upload');
$router->get('/torrents/{torrent:hash}.torrent', DownloadController::class)->name('download');
$router->get('/torrents/{torrent:hash}', DetailsController::class)->name('details');
