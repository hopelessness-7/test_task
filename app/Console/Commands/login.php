<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class login extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:{login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auth user and issuance of a token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $credentials = [
            'login' => $this->argument('login'),
            'password' => $this->argument('password')
        ];

        if(!Auth::validate($credentials)) {
            $this->error('authorization error, check the login or (and) password');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        $token = $user->createToken($user->login)->plainTextToken;

        $this->info("User token: " .$token);
    }
}
