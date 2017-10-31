<?php

namespace App\Console\Commands;

use App\Torrent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Purge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cachent:clear
                            {--with-files : Remove the torrents directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate Torrents table (Destroy all entries)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Torrent::truncate();

        if (Torrent::get()->count() === 0) {
            $this->output->success('All entries in Torrents have been purged.');
        } else {
            $this->output->warning('Purge Unsuccessful!');
        }

        if ($this->option('with-files')) {
            Storage::deleteDirectory('torrents');
        }
    }
}
