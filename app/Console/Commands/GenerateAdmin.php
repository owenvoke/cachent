<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use DB;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cachent:admin
                            {--generate : Generate a default admin user}
                            {--username= : Specify username}
                            {--password= : Specify password}
                            {--email= : Specify email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a admin user';

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
        $continue = true;

        if ($this->option('username') || $this->option('password') || $this->option('email') || $this->option('generate')) {
            $username = $this->option('username') ?? 'admin';
            $email = $this->option('email') ?? 'admin@cachent';
            $password = $this->option('password') ?? str_random(25);

            try {
                DB::table('users')->insert([
                    'username' => $username,
                    'email'    => $email,
                    'password' => bcrypt($password)
                ]);
            } catch (\PDOException $e) {
                switch ($e->getCode()) {
                    case 23000:
                        $this->error('A duplicate user already exists.');
                        break;
                    default:
                        $this->error('An unknown error occurred.');
                }

                $continue = false;
            }

            if ($continue) {
                $this->info("Username: " . $username);
                $this->info("Email: " . $email);
                $this->info("Password: " . $password);
            }
        } else {
            $this->error('No options provided.');
        }
    }
}
