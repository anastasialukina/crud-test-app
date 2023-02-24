<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ApiLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:login {email} {password}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authenticate a user using the API and JWT tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->json('status') !== 'success') {
            $this->error('Invalid email or password');
            return -1;
        }

        $token = $response->json('authorisation.token');

        $this->info('Token: ' . $token);

        return 0;
    }
}
