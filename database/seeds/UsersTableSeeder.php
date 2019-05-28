<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $username = 'admin';
        $email = 'admin@cachent';
        $password = Str::random(25);

        $output = new ConsoleOutput();
        $output->writeln([
            '',
            'Email: ' . $email,
            'Password: ' . $password
        ]);

        DB::table('users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password)
        ]);
    }
}
