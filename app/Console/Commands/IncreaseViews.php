<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class IncreaseViews extends Command
{
    protected $signature = 'increase-views {url} {count}';

    protected $description = 'Increase views for a URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $url = $this->argument('url');
        $count = $this->argument('count');
        $client = new Client();

        for ($i = 1; $i <= $count; $i++) {
            $response = $client->get($url);
            $this->info("Request $i: Status Code - " . $response->getStatusCode());
        }
    }
}
