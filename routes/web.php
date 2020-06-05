<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TorrentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main
Route::view('/', 'index')->name('index');

// Torrent
Route::post('torrents', [TorrentController::class, 'store'])->name('torrents.store');
Route::get('torrents/{torrent:hash}', [TorrentController::class, 'show'])->name('torrents.show');

// Administration
Route::group(['middleware' => ['auth']], function () {
    Route::get('torrents', [TorrentController::class, 'index'])->name('torrents.index');
    Route::delete('torrents/{torrent:hash}', [TorrentController::class, 'destroy'])->name('torrents.delete');
    Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index');
    Route::get('statistics/{torrent:hash}', [StatisticController::class, 'show'])->name('statistics.show');
    Route::delete('statistics', [StatisticController::class, 'purge'])->name('statistics.purge');
});

// Authentication
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
