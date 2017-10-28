<?php

use Illuminate\Foundation\Inspiring;
use App\Torrent;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('cachent:clear', function() {
    $this->comment(Torrent::truncate()->get()->count() == 0 ? 'All entries in Torrents have been purged.' : 'Purge Unsuccessful!');
})->describe('Truncate Torrents table (Destroy all entries)');