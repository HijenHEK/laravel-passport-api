<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository;

class PassportDefaultClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ClientRepository $client)
    {
        foreach (config('auth.providers') as $provider => $data) {
            $client->createPasswordGrantClient(
                null, $provider, config('app.url') , $provider
            );
        }
        return 0;
    }
}
