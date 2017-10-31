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
        if($this->option('username')||$this->option('password')||$this->option('email')||$this->option('generate')){
            $username = $this->option('username') ?? 'admin';
            $email = $this->option('email') ?? 'admin@cachent';
            $password = $this->option('password') ?? str_random(25);
            DB::table('users')->insert([
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
            $this->info("Username: ".$username);
            $this->info("Email: ".$email);
            $this->info("Password: ".$password);
        }else{
            Artisan::call("cachent:admin -h");
        }
    }
}
